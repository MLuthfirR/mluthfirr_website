<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminAccount;
use App\Support\Content;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ContentController extends Controller
{
    protected function schema(): array
    {
        return config('content_schema');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'schema'  => $this->schema(),
            'content' => Content::all(),
        ]);
    }

    public function edit(string $key)
    {
        $schema = $this->schema();
        abort_unless(isset($schema[$key]), 404);

        $section = $schema[$key];
        // "single" (profile) fields live at the top level of the content array.
        $value = $section['type'] === 'collection' ? Content::section($key, []) : Content::all();

        return view($section['type'] === 'collection' ? 'admin.collection' : 'admin.single', [
            'key'     => $key,
            'section' => $section,
            'value'   => $value,
        ]);
    }

    public function update(Request $request, string $key)
    {
        $schema = $this->schema();
        abort_unless(isset($schema[$key]), 404);

        $section = $schema[$key];

        if ($section['type'] === 'collection') {
            $existing = Content::section($key, []);
            $rows = $request->input('items', []);
            $labelField = $section['item_label'] ?? array_key_first($section['fields']);
            $items = [];

            foreach ($rows as $i => $row) {
                $item = [];
                foreach ($section['fields'] as $field => $meta) {
                    $item[$field] = $this->fieldValue(
                        $meta['type'],
                        $row[$field] ?? null,
                        $request->file("items.$i.{$field}_file"),
                        $existing[$i][$field] ?? null
                    );
                }
                // Skip blank rows (no label content)
                if (trim((string) ($item[$labelField] ?? '')) === '') {
                    continue;
                }
                $items[] = $item;
            }

            Content::setSection($key, array_values($items));
        } else {
            // "single" (profile) fields are stored at the top level of the content array.
            $all = Content::all();
            foreach ($section['fields'] as $field => $meta) {
                $all[$field] = $this->fieldValue(
                    $meta['type'],
                    $request->input($field),
                    $request->file("{$field}_file"),
                    $all[$field] ?? null
                );
            }
            Content::save($all);
        }

        return redirect()->route('admin.section.edit', $key)->with('ok', $section['label'] . ' saved.');
    }

    /** Normalise one field value by type. */
    protected function fieldValue(string $type, $input, ?UploadedFile $file, $existing)
    {
        switch ($type) {
            case 'checkbox':
                return (bool) $input;

            case 'taglist':
                if (is_array($input)) {
                    $parts = $input;
                } else {
                    $parts = preg_split('/\s*,\s*/', (string) $input, -1, PREG_SPLIT_NO_EMPTY);
                }
                return array_values(array_filter(array_map('trim', $parts), fn ($v) => $v !== ''));

            case 'image':
                $stored = $this->storeUploaded($file);
                if ($stored) {
                    return $stored;
                }
                $text = is_string($input) ? trim($input) : '';
                if ($text !== '') {
                    return $text;
                }
                return $existing; // keep current when nothing provided

            default: // text, textarea
                return is_string($input) ? trim($input) : (string) ($input ?? '');
        }
    }

    protected function storeUploaded(?UploadedFile $file): ?string
    {
        if (! $file || ! $file->isValid()) {
            return null;
        }
        $mime = (string) $file->getMimeType();
        if (! str_starts_with($mime, 'image/')) {
            return null;
        }
        $dir = public_path('uploads');
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $ext  = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $name = 'u' . date('YmdHis') . substr(bin2hex(random_bytes(4)), 0, 6) . '.' . $ext;
        $file->move($dir, $name);

        return 'uploads/' . $name;
    }

    /* ---------- Account ---------- */

    public function account()
    {
        return view('admin.account', ['account' => AdminAccount::get()]);
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        AdminAccount::updateEmail($request->input('email'));
        if ($request->filled('password')) {
            AdminAccount::updatePassword($request->input('password'));
        }

        return redirect()->route('admin.account')->with('ok', 'Account updated.');
    }
}
