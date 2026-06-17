<?php

namespace App\Support;

/**
 * Single-admin credential store kept in storage/app/content/admin.json.
 * No users table needed; the password is bcrypt-hashed. On first run the
 * admin sets their own email + password (no credentials ship in the repo).
 */
class AdminAccount
{
    protected static function path(): string
    {
        return storage_path('app/content/admin.json');
    }

    public static function exists(): bool
    {
        return is_file(self::path());
    }

    public static function get(): ?array
    {
        if (! self::exists()) {
            return null;
        }
        $data = json_decode((string) file_get_contents(self::path()), true);
        return is_array($data) ? $data : null;
    }

    public static function create(string $email, string $password): void
    {
        self::write($email, $password);
    }

    public static function updatePassword(string $password): void
    {
        $acc = self::get();
        if ($acc) {
            self::write($acc['email'], $password);
        }
    }

    public static function updateEmail(string $email): void
    {
        $acc = self::get();
        if ($acc) {
            $acc['email'] = $email;
            self::store($acc);
        }
    }

    public static function verify(string $email, string $password): bool
    {
        $acc = self::get();
        if (! $acc) {
            return false;
        }
        return hash_equals(strtolower($acc['email']), strtolower(trim($email)))
            && password_verify($password, $acc['password']);
    }

    protected static function write(string $email, string $password): void
    {
        self::store([
            'email'    => trim($email),
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }

    protected static function store(array $acc): void
    {
        $dir = dirname(self::path());
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        file_put_contents(self::path(), json_encode($acc, JSON_UNESCAPED_SLASHES));
    }
}
