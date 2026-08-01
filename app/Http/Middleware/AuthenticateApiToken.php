<?php

namespace App\Http\Middleware;

use App\Models\StudentApiToken;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $plainToken = $request->bearerToken();

        if (! is_string($plainToken) || $plainToken === '') {
            return $this->unauthenticated();
        }

        $token = StudentApiToken::query()
            ->with('account')
            ->where('token_hash', hash('sha256', $plainToken))
            ->first();

        if ($token === null || $token->account === null || $token->expires_at?->isPast()) {
            $token?->delete();

            return $this->unauthenticated();
        }

        $token->forceFill(['last_used_at' => now()])->save();
        $request->attributes->set('student_account', $token->account);
        $request->attributes->set('student_api_token', $token);

        return $next($request);
    }

    private function unauthenticated(): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated.',
            'errors' => ['token' => ['A valid bearer token is required.']],
        ], 401);
    }
}
