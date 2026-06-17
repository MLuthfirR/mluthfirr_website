<?php

namespace App\Support;

/**
 * File-backed content store. Defaults come from config/profile.php; once the
 * admin saves, content lives in storage/app/content/profile.json (which
 * persists across git deploys and needs no database).
 */
class Content
{
    protected static function path(): string
    {
        return storage_path('app/content/profile.json');
    }

    /** Full content array (saved overrides config defaults, merged at top level). */
    public static function all(): array
    {
        $defaults = config('profile', []);
        $path = self::path();
        if (is_file($path)) {
            $saved = json_decode((string) file_get_contents($path), true);
            if (is_array($saved)) {
                return array_merge($defaults, $saved);
            }
        }
        return $defaults;
    }

    public static function section(string $key, $default = null)
    {
        return self::all()[$key] ?? $default;
    }

    /** Replace one top-level section and persist the whole structure. */
    public static function setSection(string $key, $value): void
    {
        $data = self::all();
        $data[$key] = $value;
        self::save($data);
    }

    public static function save(array $data): void
    {
        $dir = dirname(self::path());
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        file_put_contents(
            self::path(),
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }
}
