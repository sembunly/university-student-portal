<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use App\Models\StudentRegistration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $account = StudentAccount::query()->findOrFail(
            $request->session()->get('student_account_id'),
        );
        $studentId = $account->student_id;
        $registration = StudentRegistration::query()
            ->with([
                'currentProvince:id,name',
                'currentDistrict:id,name',
                'currentCommune:id,name',
                'currentVillage:id,name',
            ])
            ->where('student_id', $studentId)
            ->first();

        return view('student.dashboard', [
            'student' => $this->studentData($registration, $studentId, $account->phone),
            'hasRegistration' => $registration !== null,
            'profileCompletion' => $this->profileCompletion($registration),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function studentData(?StudentRegistration $registration, ?string $studentId, ?string $phone): array
    {
        return [
            'name_km' => $registration?->name_km,
            'name_en' => $registration?->name_en,
            'student_id' => $studentId ?: '—',
            'phone' => $registration?->phone ?: ($phone ?: '—'),
            'email' => $registration?->email ?: '—',
            'date_of_birth' => $registration?->date_of_birth?->format('Y-m-d') ?: '—',
            'gender' => $registration?->gender ?: '—',
            'nationality' => $registration?->nationality ?: '—',
            'address' => $this->currentAddress($registration),
            'avatar' => null,
        ];
    }

    private function currentAddress(?StudentRegistration $registration): string
    {
        if ($registration === null) {
            return '—';
        }

        $locationName = static function ($location): ?string {
            if ($location === null) {
                return null;
            }

            return $location->name;
        };

        return collect([
            $registration->current_house,
            $registration->current_street,
            $locationName($registration->currentVillage),
            $locationName($registration->currentCommune),
            $locationName($registration->currentDistrict),
            $locationName($registration->currentProvince),
        ])->filter()->join(', ') ?: '—';
    }

    private function profileCompletion(?StudentRegistration $registration): int
    {
        if ($registration === null) {
            return 0;
        }

        $fields = [
            'name_km',
            'name_en',
            'date_of_birth',
            'gender',
            'nationality',
            'phone',
            'email',
            'current_province_id',
            'current_district_id',
            'current_commune_id',
            'current_village_id',
            'permanent_province_id',
            'permanent_district_id',
            'permanent_commune_id',
            'permanent_village_id',
            'father_name',
            'father_occupation',
            'father_phone',
            'mother_name',
            'mother_occupation',
            'mother_phone',
            'emergency_name',
            'emergency_phone',
            'high_school',
            'graduation_year',
            'education_province_id',
            'certificate_path',
        ];

        $completed = collect($fields)
            ->filter(fn (string $field) => filled($registration->getAttribute($field)))
            ->count();

        return (int) round(($completed / count($fields)) * 100);
    }
}
