<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Verifies a Cloudflare Turnstile token on protected POST routes (admin login,
 * setup). Skipped when the secret isn't configured, so the site keeps working
 * until the keys are added.
 */
class VerifyTurnstile
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = (string) config('services.turnstile.secret', '');
        if ($secret === '') {
            return $next($request);
        }

        $token = (string) $request->input('cf-turnstile-response', '');
        $ok = false;

        if ($token !== '') {
            try {
                $resp = Http::asForm()->timeout(10)->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    ['secret' => $secret, 'response' => $token]
                );
                $ok = $resp->successful() && (bool) $resp->json('success');
            } catch (Throwable $e) {
                $ok = false;
            }
        }

        if (! $ok) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['email' => 'Security verification failed. Please try again.']);
        }

        return $next($request);
    }
}
