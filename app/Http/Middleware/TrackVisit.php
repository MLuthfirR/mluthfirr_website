<?php

namespace App\Http\Middleware;

use App\Support\Analytics;
use Closure;
use Illuminate\Http\Request;

class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            // Only count real GET page views, and never count the admin's own visits.
            if ($request->isMethod('GET') && ! $request->session()->get('admin_authed')) {
                $ua = (string) $request->userAgent();
                $info = Analytics::parseUa($ua);

                $referer = $request->headers->get('referer');
                $refHost = $referer ? (parse_url($referer, PHP_URL_HOST) ?: 'direct') : 'direct';
                $selfHost = parse_url((string) config('app.url'), PHP_URL_HOST) ?: '';
                if ($refHost !== 'direct' && ($refHost === $selfHost || str_contains($refHost, 'mluthfirr'))) {
                    $refHost = 'internal';
                }

                Analytics::record([
                    'ts'      => time(),
                    'path'    => '/' . ltrim($request->path(), '/'),
                    'ref'     => $refHost,
                    'country' => $request->headers->get('CF-IPCountry') ?: '??',
                    'browser' => $info['browser'],
                    'os'      => $info['os'],
                    'device'  => $info['device'],
                    'bot'     => $info['bot'],
                    'ip'      => substr(hash('sha256', ((string) $request->ip()) . '|' . config('app.key')), 0, 16),
                ]);
            }
        } catch (\Throwable $e) {
            // Analytics must never break the page.
        }

        return $response;
    }
}
