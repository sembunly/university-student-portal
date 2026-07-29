<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\StudentAccount;
use App\Models\StudentRegistration;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private const RELATIONS = [
        'currentProvince:id,code,name,name_other',
        'currentDistrict:id,code,name,name_other',
        'currentCommune:id,code,name,name_other',
        'currentVillage:id,code,name,name_other',
        'permanentProvince:id,code,name,name_other',
        'permanentDistrict:id,code,name,name_other',
        'permanentCommune:id,code,name,name_other',
        'permanentVillage:id,code,name,name_other',
        'educationProvince:id,code,name,name_other',
    ];

    public function show(Request $request): JsonResponse
    {
        $account = $this->account($request);
        $profile = $account->student_id === null
            ? null
            : StudentRegistration::query()
                ->with(self::RELATIONS)
                ->where('student_id', $account->student_id)
                ->first();

        return response()->json([
            'data' => [
                'account' => $this->accountData($account),
                'profile' => $profile === null ? null : $this->profileData($profile),
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $account = $this->account($request);
        $validated = $request->validate($this->rules($request, $account));
        unset($validated['certificate']);
        $validated['phone'] = $account->phone;

        $existing = $account->student_id === null
            ? null
            : StudentRegistration::query()->where('student_id', $account->student_id)->first();
        $oldCertificate = $existing?->certificate_path;
        $newCertificate = $request->file('certificate')?->store('student-certificates', 'public');

        if ($newCertificate !== null) {
            $validated['certificate_path'] = $newCertificate;
        }

        try {
            $profile = DB::transaction(function () use ($account, $validated): StudentRegistration {
                if ($account->student_id === null) {
                    $account->forceFill(['student_id' => $this->studentIdForAccount($account)])->save();
                }

                return StudentRegistration::query()->updateOrCreate(
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

        $profile->load(self::RELATIONS);

        return response()->json([
            'message' => 'Profile saved successfully.',
            'data' => [
                'account' => $this->accountData($account->refresh()),
                'profile' => $this->profileData($profile),
            ],
        ]);
    }

    private function rules(Request $request, StudentAccount $account): array
    {
        $rules = [
            'name_km' => ['required', 'string', 'max:100'],
            'name_en' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['ប្រុស', 'ស្រី'])],
            'nationality' => ['nullable', 'string', 'max:100'],
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

    private function studentIdForAccount(StudentAccount $account): string
    {
        do {
            $number = DB::table('student_id_sequences')->insertGetId([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $studentId = str_pad((string) $number, 4, '0', STR_PAD_LEFT);
        } while (
            StudentAccount::query()->whereKeyNot($account->getKey())->where('student_id', $studentId)->exists()
            || StudentRegistration::query()->where('student_id', $studentId)->exists()
        );

        return $studentId;
    }

    private function profileData(StudentRegistration $profile): array
    {
        $data = $profile->only([
            'student_id', 'name_km', 'name_en', 'gender', 'nationality', 'phone', 'email',
            'current_province_id', 'current_district_id', 'current_commune_id', 'current_village_id',
            'current_house', 'current_street',
            'permanent_province_id', 'permanent_district_id', 'permanent_commune_id', 'permanent_village_id',
            'permanent_house', 'permanent_street',
            'father_name', 'father_occupation', 'father_phone',
            'mother_name', 'mother_occupation', 'mother_phone',
            'emergency_name', 'emergency_phone', 'high_school', 'graduation_year',
            'education_province_id',
        ]);
        $data['date_of_birth'] = $profile->date_of_birth?->format('Y-m-d');
        $data['certificate_url'] = $profile->certificate_path === null
            ? null
            : Storage::disk('public')->url($profile->certificate_path);
        $data['locations'] = [
            'current' => [
                'province' => $profile->currentProvince,
                'district' => $profile->currentDistrict,
                'commune' => $profile->currentCommune,
                'village' => $profile->currentVillage,
            ],
            'permanent' => [
                'province' => $profile->permanentProvince,
                'district' => $profile->permanentDistrict,
                'commune' => $profile->permanentCommune,
                'village' => $profile->permanentVillage,
            ],
            'education_province' => $profile->educationProvince,
        ];

        return $data;
    }

    private function accountData(StudentAccount $account): array
    {
        return [
            'id' => $account->getKey(),
            'student_id' => $account->student_id,
            'phone' => $account->phone,
            'profile_completed' => $account->student_id !== null,
        ];
    }

    private function account(Request $request): StudentAccount
    {
        return $request->attributes->get('student_account');
    }
}
