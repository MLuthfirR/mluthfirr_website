<?php

namespace App\Support;

use DateTime;
use DateTimeZone;

/**
 * Privacy-friendly, file-based visit analytics. One JSONL line per visit in
 * storage/app/analytics/Y-m-d.jsonl (no database, persists across deploys).
 * IPs are stored only as a salted hash (for unique counting), never raw.
 */
class Analytics
{
    const TZ = 'Asia/Jakarta';

    protected static function dir(): string
    {
        return storage_path('app/analytics');
    }

    public static function dayKey(?int $ts = null): string
    {
        $dt = new DateTime('@' . ($ts ?? time()));
        $dt->setTimezone(new DateTimeZone(self::TZ));
        return $dt->format('Y-m-d');
    }

    public static function record(array $row): void
    {
        $dir = self::dir();
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @file_put_contents(
            $dir . '/' . self::dayKey($row['ts'] ?? null) . '.jsonl',
            json_encode($row, JSON_UNESCAPED_SLASHES) . "\n",
            FILE_APPEND | LOCK_EX
        );
    }

    /** Parse a user-agent into browser / OS / device / bot flag (no external lib). */
    public static function parseUa(string $ua): array
    {
        $bot = (bool) preg_match('/bot|crawl|spider|slurp|bingpreview|facebookexternalhit|embedly|pinterest|headless|lighthouse|monitor|preview|curl|wget|python-requests|axios|go-http|httpclient|scrapy/i', $ua);

        $os = 'Other';
        if (preg_match('/windows nt/i', $ua)) $os = 'Windows';
        elseif (preg_match('/iphone|ipad|ipod/i', $ua)) $os = 'iOS';
        elseif (preg_match('/mac os x/i', $ua)) $os = 'macOS';
        elseif (preg_match('/android/i', $ua)) $os = 'Android';
        elseif (preg_match('/linux/i', $ua)) $os = 'Linux';

        $device = 'Desktop';
        if (preg_match('/ipad|tablet/i', $ua)) $device = 'Tablet';
        elseif (preg_match('/mobi|iphone|android.*mobile|windows phone/i', $ua)) $device = 'Mobile';
        elseif (preg_match('/android/i', $ua)) $device = 'Tablet';

        $browser = 'Other';
        if (preg_match('/edg/i', $ua)) $browser = 'Edge';
        elseif (preg_match('/opr|opera/i', $ua)) $browser = 'Opera';
        elseif (preg_match('/samsungbrowser/i', $ua)) $browser = 'Samsung';
        elseif (preg_match('/firefox|fxios/i', $ua)) $browser = 'Firefox';
        elseif (preg_match('/edgios/i', $ua)) $browser = 'Edge';
        elseif (preg_match('/crios|chrome/i', $ua)) $browser = 'Chrome';
        elseif (preg_match('/safari/i', $ua)) $browser = 'Safari';

        return compact('browser', 'os', 'device', 'bot');
    }

    /** Aggregate the last $days days (0 = all time) into a report structure. */
    public static function summary(int $days): array
    {
        $dir = self::dir();
        $tz = new DateTimeZone(self::TZ);

        $dayKeys = [];
        if ($days > 0) {
            for ($i = $days - 1; $i >= 0; $i--) {
                $d = new DateTime('now', $tz);
                $d->modify("-$i day");
                $dayKeys[] = $d->format('Y-m-d');
            }
        } else {
            foreach (glob($dir . '/*.jsonl') ?: [] as $f) {
                $dayKeys[] = basename($f, '.jsonl');
            }
            sort($dayKeys);
        }

        $todayKey = self::dayKey();
        $views = 0; $todayViews = 0; $bots = 0;
        $uniques = []; $ref = []; $country = []; $browser = []; $os = []; $device = []; $path = [];
        $perDay = [];

        foreach ($dayKeys as $dk) {
            $perDay[$dk] = ['views' => 0, 'uniq' => []];
            $file = $dir . '/' . $dk . '.jsonl';
            if (! is_file($file)) continue;
            $fh = @fopen($file, 'r');
            if (! $fh) continue;
            while (($line = fgets($fh)) !== false) {
                $r = json_decode(trim($line), true);
                if (! is_array($r)) continue;
                if (! empty($r['bot'])) { $bots++; continue; }

                $views++;
                $perDay[$dk]['views']++;
                if ($dk === $todayKey) $todayViews++;

                $ip = $r['ip'] ?? '';
                if ($ip !== '') { $uniques[$ip] = 1; $perDay[$dk]['uniq'][$ip] = 1; }

                $rf = $r['ref'] ?? 'direct'; $ref[$rf] = ($ref[$rf] ?? 0) + 1;
                $c  = $r['country'] ?? '??'; $country[$c] = ($country[$c] ?? 0) + 1;
                $b  = $r['browser'] ?? 'Other'; $browser[$b] = ($browser[$b] ?? 0) + 1;
                $o  = $r['os'] ?? 'Other'; $os[$o] = ($os[$o] ?? 0) + 1;
                $dv = $r['device'] ?? 'Desktop'; $device[$dv] = ($device[$dv] ?? 0) + 1;
                $p  = $r['path'] ?? '/'; $path[$p] = ($path[$p] ?? 0) + 1;
            }
            fclose($fh);
        }

        $series = [];
        foreach ($perDay as $dk => $v) {
            $series[] = ['date' => $dk, 'views' => $v['views'], 'uniq' => count($v['uniq'])];
        }

        arsort($ref); arsort($country); arsort($browser); arsort($os); arsort($device); arsort($path);

        $nDays = max(1, count($dayKeys));

        return [
            'days'           => $days,
            'totalViews'     => $views,
            'uniqueVisitors' => count($uniques),
            'todayViews'     => $todayViews,
            'avgPerDay'      => round($views / $nDays, 1),
            'bots'           => $bots,
            'series'         => $series,
            'referrers'      => $ref,
            'countries'      => $country,
            'browsers'       => $browser,
            'os'             => $os,
            'devices'        => $device,
            'paths'          => $path,
        ];
    }

    /** Country ISO-2 code -> flag emoji. */
    public static function flag(string $cc): string
    {
        $cc = strtoupper(trim($cc));
        if (strlen($cc) !== 2 || ! ctype_alpha($cc)) {
            return '🏳️';
        }
        $base = 0x1F1E6;
        return mb_chr($base + (ord($cc[0]) - 65)) . mb_chr($base + (ord($cc[1]) - 65));
    }
}
