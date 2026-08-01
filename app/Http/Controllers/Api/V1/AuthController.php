<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\StudentAccount;
use App\Models\StudentApiToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->merge(['phone' => $this->normalizePhone((string) $request->input('phone'))]);
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^0\d{8,9}$/', 'unique:student_accounts,phone'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $account = StudentAccount::query()->create([
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ]);

        return response()->json([
            'message' => 'Account registered successfully.',
            'data' => $this->tokenData($account, $validated['device_name'] ?? 'flutter'),
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->merge(['login' => trim((string) $request->input('login'))]);
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $phone = $this->normalizePhone($validated['login']);
        $account = StudentAccount::query()
            ->where('student_id', $validated['login'])
            ->when($phone !== '', fn ($query) => $query->orWhere('phone', $phone))
            ->first();

        if ($account === null || ! Hash::check($validated['password'], $account->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
                'errors' => ['login' => ['The provided credentials are incorrect.']],
            ], 422);
        }

        return response()->json([
            'message' => 'Logged in successfully.',
            'data' => $this->tokenData($account, $validated['device_name'] ?? 'flutter'),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->accountData($this->account($request))]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->attributes->get('student_api_token')->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    private function tokenData(StudentAccount $account, string $deviceName): array
    {
        $plainToken = Str::random(80);
        StudentApiToken::query()->create([
            'student_account_id' => $account->getKey(),
            'name' => $deviceName,
            'token_hash' => hash('sha256', $plainToken),
        ]);

        return [
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'account' => $this->accountData($account),
        ];
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

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone) ?? '';

        return str_starts_with($phone, '855') ? '0'.substr($phone, 3) : $phone;
    }
}
