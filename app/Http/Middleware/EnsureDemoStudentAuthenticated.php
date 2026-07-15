<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDemoStudentAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('student_demo_authenticated') !== true) {
            return to_route('student.login');
        }

        return $next($request);
    }
}
