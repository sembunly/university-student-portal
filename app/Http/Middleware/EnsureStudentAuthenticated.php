<?php

namespace App\Http\Middleware;

use App\Models\StudentAccount;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('student_authenticated') !== true) {
            return to_route('student.login');
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

            return to_route('student.login');
        }

        $request->session()->put([
            'student_account_id' => $account->getKey(),
            'student_id' => $account->student_id,
            'student_phone' => $account->phone,
        ]);

        return $next($request);
    }
}
