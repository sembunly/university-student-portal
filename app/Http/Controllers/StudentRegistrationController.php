<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\StudentAccount;
use App\Models\StudentRegistration;
use App\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentRegistrationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $studentId = $this->studentAccount($request)->student_id;

        if ($studentId === null) {
            return to_route('student.information.edit');
        }

        $student = StudentRegistration::query()
            ->with([
                'currentProvince:id,name',
                'currentDistrict:id,name',
                'currentCommune:id,name',
                'currentVillage:id,name',
                'permanentProvince:id,name',
                'permanentDistrict:id,name',
                'permanentCommune:id,name',
                'permanentVillage:id,name',
                'educationProvince:id,name',
            ])
            ->where('student_id', $studentId)
            ->first();

        if ($student === null) {
            return to_route('student.information.edit');
        }

        return view('student.student-information', [
            'student' => $student,
            'informationSections' => $this->informationSections($student),
        ]);
    }

    public function edit(Request $request): View
    {
        $account = $this->studentAccount($request);
        $student = StudentRegistration::query()
            ->where('student_id', $account->student_id)
            ->first();

        return view('student.update-student-information', [
            'student' => $student,
            'studentId' => $account->student_id,
            'accountPhone' => $account->phone,
            'provinces' => Province::query()
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'name']),
            'addressOptions' => [
                'current' => $this->addressOptions($request, $student, 'current'),
                'permanent' => $this->addressOptions($request, $student, 'permanent'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $account = $this->studentAccount($request);
        $validated = $request->validate($this->rules($request));
        unset($validated['declaration'], $validated['certificate']);
        $validated['phone'] = $account->phone;

        $student = StudentRegistration::query()
            ->where('student_id', $account->student_id)
            ->first();
        $oldCertificate = $student?->certificate_path;
        $newCertificate = $request->file('certificate')?->store('student-certificates', 'public');

        if ($newCertificate !== null) {
            $validated['certificate_path'] = $newCertificate;
        }

        try {
            DB::transaction(function () use ($account, $validated): void {
                if ($account->student_id === null) {
                    $account->forceFill([
                        'student_id' => $this->studentIdForAccount($account),
                    ])->save();
                }

                StudentRegistration::query()->updateOrCreate(
                    ['student_id' => $account->student_id],
                    $validated,
                );
            });
        } catch (\Throwable $exception) {
            if ($newCertificate !== null) {
                Storage::disk('public')->delete($newCertificate);
            }

            throw $exception;
        }

        if ($newCertificate !== null && $oldCertificate !== null) {
            Storage::disk('public')->delete($oldCertificate);
        }

        $request->session()->put('student_id', $account->student_id);

        return to_route('student.dashboard')
            ->with('success', "ព័ត៌មានត្រូវបានរក្សាទុក។ លេខសម្គាល់និស្សិតរបស់អ្នកគឺ {$account->student_id}។");
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(Request $request): array
    {
        $rules = [
            'name_km' => ['required', 'string', 'max:100'],
            'name_en' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['ប្រុស', 'ស្រី'])],
            'nationality' => ['nullable', 'string', 'max:100'],
            'phone' => [
                'required',
                Rule::in([$this->studentAccount($request)->phone]),
            ],
            'email' => ['nullable', 'email', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'father_occupation' => ['nullable', 'string', 'max:255'],
            'father_phone' => ['nullable', 'string', 'max:30'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'mother_occupation' => ['nullable', 'string', 'max:255'],
            'mother_phone' => ['nullable', 'string', 'max:30'],
            'emergency_name' => ['required', 'string', 'max:255'],
            'emergency_phone' => ['required', 'string', 'max:30'],
            'high_school' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'integer', 'between:1900,'.date('Y')],
            'education_province_id' => [
                'nullable',
                Rule::exists('provinces', 'id')->where('is_active', true),
            ],
            'certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'declaration' => ['accepted'],
        ];

        foreach (['current', 'permanent'] as $prefix) {
            $rules["{$prefix}_province_id"] = [
                'required',
                Rule::exists('provinces', 'id')->where('is_active', true),
            ];
            $rules["{$prefix}_district_id"] = [
                'required',
                Rule::exists('districts', 'id')->where(
                    fn (Builder $query) => $query
                        ->where('province_id', $request->integer("{$prefix}_province_id"))
                        ->where('is_active', true),
                ),
            ];
            $rules["{$prefix}_commune_id"] = [
                'required',
                Rule::exists('communes', 'id')->where(
                    fn (Builder $query) => $query
                        ->where('district_id', $request->integer("{$prefix}_district_id"))
                        ->where('is_active', true),
                ),
            ];
            $rules["{$prefix}_village_id"] = [
                'required',
                Rule::exists('villages', 'id')->where(
                    fn (Builder $query) => $query
                        ->where('commune_id', $request->integer("{$prefix}_commune_id"))
                        ->where('is_active', true),
                ),
            ];
            $rules["{$prefix}_house"] = ['nullable', 'string', 'max:50'];
            $rules["{$prefix}_street"] = ['nullable', 'string', 'max:100'];
        }

        return $rules;
    }

    /**
     * @return array{districts: Collection, communes: Collection, villages: Collection}
     */
    private function addressOptions(Request $request, ?StudentRegistration $student, string $prefix): array
    {
        $provinceId = $request->old("{$prefix}_province_id", $student?->getAttribute("{$prefix}_province_id"));
        $districtId = $request->old("{$prefix}_district_id", $student?->getAttribute("{$prefix}_district_id"));
        $communeId = $request->old("{$prefix}_commune_id", $student?->getAttribute("{$prefix}_commune_id"));

        return [
            'districts' => District::query()
                ->where('province_id', $provinceId)
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'name']),
            'communes' => Commune::query()
                ->where('district_id', $districtId)
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'name']),
            'villages' => Village::query()
                ->where('commune_id', $communeId)
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'name']),
        ];
    }

    private function studentAccount(Request $request): StudentAccount
    {
        return StudentAccount::query()->findOrFail(
            $request->session()->get('student_account_id'),
        );
    }

    private function studentIdForAccount(StudentAccount $account): string
    {
        do {
            $number = DB::table('student_id_sequences')->insertGetId([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $studentId = str_pad((string) $number, 4, '0', STR_PAD_LEFT);
        } while (
            StudentAccount::query()
                ->whereKeyNot($account->getKey())
                ->where('student_id', $studentId)
                ->exists()
            || StudentRegistration::query()->where('student_id', $studentId)->exists()
        );

        return $studentId;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function informationSections(StudentRegistration $student): array
    {
        return [
            [
                'title' => 'ប្រវត្តិរូបផ្ទាល់ខ្លួន',
                'subtitle' => 'ព័ត៌មានដែលបានរក្សាទុកក្នុងប្រព័ន្ធ',
                'items' => [
                    ['label' => 'លេខសម្គាល់និស្សិត', 'value' => $student->student_id],
                    ['label' => 'ឈ្មោះជាភាសាខ្មែរ', 'value' => $student->name_km],
                    ['label' => 'ឈ្មោះជាភាសាអង់គ្លេស', 'value' => $student->name_en],
                    ['label' => 'ថ្ងៃខែឆ្នាំកំណើត', 'value' => $student->date_of_birth?->format('Y-m-d')],
                    ['label' => 'ភេទ', 'value' => $student->gender],
                    ['label' => 'សញ្ជាតិ', 'value' => $student->nationality],
                    ['label' => 'លេខទូរស័ព្ទ', 'value' => $student->phone],
                    ['label' => 'អ៊ីមែល', 'value' => $student->email],
                ],
            ],
            $this->addressSection($student, 'current', 'អាសយដ្ឋានបច្ចុប្បន្ន'),
            $this->addressSection($student, 'permanent', 'អាសយដ្ឋានអចិន្ត្រៃយ៍'),
            [
                'title' => 'ព័ត៌មានគ្រួសារ និងទំនាក់ទំនងបន្ទាន់',
                'items' => [
                    ['label' => 'ឈ្មោះឪពុក', 'value' => $student->father_name],
                    ['label' => 'មុខរបរឪពុក', 'value' => $student->father_occupation],
                    ['label' => 'លេខទូរស័ព្ទឪពុក', 'value' => $student->father_phone],
                    ['label' => 'ឈ្មោះម្ដាយ', 'value' => $student->mother_name],
                    ['label' => 'មុខរបរម្ដាយ', 'value' => $student->mother_occupation],
                    ['label' => 'លេខទូរស័ព្ទម្ដាយ', 'value' => $student->mother_phone],
                    ['label' => 'ឈ្មោះអ្នកទំនាក់ទំនងបន្ទាន់', 'value' => $student->emergency_name],
                    ['label' => 'លេខទូរស័ព្ទបន្ទាន់', 'value' => $student->emergency_phone],
                ],
            ],
            [
                'title' => 'ប្រវត្តិសិក្សា',
                'items' => [
                    ['label' => 'ឈ្មោះវិទ្យាល័យ', 'value' => $student->high_school],
                    ['label' => 'ឆ្នាំបញ្ចប់ការសិក្សា', 'value' => $student->graduation_year],
                    ['label' => 'រាជធានី/ខេត្តនៃវិទ្យាល័យ', 'value' => $this->locationName($student->educationProvince)],
                    ['label' => 'ឯកសារបញ្ជាក់ការសិក្សា', 'value' => $student->certificate_path ? basename($student->certificate_path) : null],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function addressSection(StudentRegistration $student, string $prefix, string $title): array
    {
        return [
            'title' => $title,
            'items' => [
                ['label' => 'រាជធានី/ខេត្ត', 'value' => $this->locationName($student->getRelation("{$prefix}Province"))],
                ['label' => 'ក្រុង/ស្រុក/ខណ្ឌ', 'value' => $this->locationName($student->getRelation("{$prefix}District"))],
                ['label' => 'ឃុំ/សង្កាត់', 'value' => $this->locationName($student->getRelation("{$prefix}Commune"))],
                ['label' => 'ភូមិ', 'value' => $this->locationName($student->getRelation("{$prefix}Village"))],
                ['label' => 'លេខផ្ទះ', 'value' => $student->getAttribute("{$prefix}_house")],
                ['label' => 'លេខផ្លូវ', 'value' => $student->getAttribute("{$prefix}_street")],
            ],
        ];
    }

    private function locationName(?Model $location): ?string
    {
        if ($location === null) {
            return null;
        }

        return $location->name;
    }
}
