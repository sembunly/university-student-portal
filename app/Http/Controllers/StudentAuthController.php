<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class StudentAuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($this->authenticatedAccount($request) !== null) {
            return to_route('student.dashboard');
        }

        return view('student.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->merge([
            'login' => trim((string) $request->input('login')),
        ]);

        $credentials = $request->validate([
            'login' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string'],
        ]);

        $login = $credentials['login'];
        $phone = $this->normalizePhone($login);
        $account = StudentAccount::query()
            ->where('student_id', $login)
            ->when($phone !== '', fn ($query) => $query->orWhere('phone', $phone))
            ->first();

        if ($account === null || ! Hash::check($credentials['password'], $account->password)) {
            return back()
                ->withErrors(['login' => __('student.login.invalid')])
                ->onlyInput('login');
        }

        $this->authenticate($request, $account);

        return to_route('student.dashboard');
    }

    public function showRegister(Request $request): View|RedirectResponse
    {
        if ($this->authenticatedAccount($request) !== null) {
            return to_route('student.dashboard');
        }

        return view('student.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->merge([
            'phone' => $this->normalizePhone((string) $request->input('phone')),
        ]);

        $validated = $request->validate([
            'phone' => ['required', 'regex:/^0\d{8,9}$/', 'unique:student_accounts,phone'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $account = StudentAccount::query()->create([
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ]);

        $this->authenticate($request, $account);

        return to_route('student.dashboard')
            ->with('success', __('student.register.success'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('student.login');
    }

    private function authenticate(Request $request, StudentAccount $account): void
    {
        $request->session()->regenerate();
        $request->session()->put([
            'student_authenticated' => true,
            'student_account_id' => $account->getKey(),
            'student_id' => $account->student_id,
            'student_phone' => $account->phone,
        ]);
    }

    private function authenticatedAccount(Request $request): ?StudentAccount
    {
        if ($request->session()->get('student_authenticated') !== true) {
            return null;
        }

        $account = StudentAccount::query()->find(
            $request->session()->get('student_account_id'),
        );

        if ($account === null && filled($request->session()->get('student_id'))) {
            $account = StudentAccount::query()
                ->where('student_id', $request->session()->get('student_id'))
                ->first();
        }

        if ($account === null) {
            $request->session()->forget([
                'student_authenticated',
                'student_account_id',
                'student_id',
                'student_phone',
            ]);

            return null;
        }

        $request->session()->put([
            'student_account_id' => $account->getKey(),
            'student_id' => $account->student_id,
            'student_phone' => $account->phone,
        ]);

        return $account;
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone) ?? '';

        return str_starts_with($phone, '855')
            ? '0'.substr($phone, 3)
            : $phone;
    }
}
