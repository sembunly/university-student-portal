<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\StudentAccount;
use App\Models\StudentRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    /**
     * GET /api/v1/student/dashboard
     */
    public function index(Request $request): JsonResponse
    {
        [$account, $registration] = $this->studentProfile($request);

        return response()->json([
            'success' => true,
            'message' => 'Student dashboard retrieved successfully.',
            'data' => [
                'student' => $this->studentData(
                    $registration,
                    $account->student_id,
                    $account->phone,
                ),
                'has_registration' => $registration !== null,
                'profile_completion' => $this->profileCompletion($registration),
            ],
        ]);
    }

    /**
     * GET /api/v1/student/curriculum
     */
    public function curriculum(Request $request): JsonResponse
    {
        [$account, $registration] = $this->studentProfile($request);

        return response()->json([
            'success' => true,
            'message' => 'Student curriculum retrieved successfully.',
            'data' => [
                'student' => $this->studentData(
                    $registration,
                    $account->student_id,
                    $account->phone,
                ),
            ],
        ]);
    }

    /**
     * @return array{0: StudentAccount, 1: StudentRegistration|null}
     */
    private function studentProfile(Request $request): array
    {
        $studentAccountId = $request->session()->get('student_account_id');

        abort_if(
            blank($studentAccountId),
            401,
            'Student account session not found.',
        );

        $account = StudentAccount::query()->findOrFail($studentAccountId);

        $registration = StudentRegistration::query()
            ->with([
                'currentProvince:id,name',
                'currentDistrict:id,name',
                'currentCommune:id,name',
                'currentVillage:id,name',
            ])
            ->where('student_id', $account->student_id)
            ->first();

        return [$account, $registration];
    }

    /**
     * @return array<string, mixed>
     */
    private function studentData(
        ?StudentRegistration $registration,
        ?string $studentId,
        ?string $phone,
    ): array {
        return [
            'name_km' => $registration?->name_km,
            'name_en' => $registration?->name_en,
            'student_id' => $studentId,
            'phone' => $registration?->phone ?: $phone,
            'email' => $registration?->email,
            'date_of_birth' => $registration?->date_of_birth?->format('Y-m-d'),
            'gender' => $registration?->gender,
            'nationality' => $registration?->nationality,
            'address' => $this->currentAddress($registration),
            'avatar' => null,
        ];
    }

    private function currentAddress(
        ?StudentRegistration $registration,
    ): ?string {
        if ($registration === null) {
            return null;
        }

        $address = collect([
            $registration->current_house,
            $registration->current_street,
            $registration->currentVillage?->name,
            $registration->currentCommune?->name,
            $registration->currentDistrict?->name,
            $registration->currentProvince?->name,
        ])
            ->filter(fn ($value) => filled($value))
            ->join(', ');

        return $address !== '' ? $address : null;
    }

    private function profileCompletion(
        ?StudentRegistration $registration,
    ): int {
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

        $completedFields = collect($fields)
            ->filter(
                fn (string $field): bool =>
                    filled($registration->getAttribute($field)),
            )
            ->count();

        return (int) round(
            ($completedFields / count($fields)) * 100,
        );
    }
}
