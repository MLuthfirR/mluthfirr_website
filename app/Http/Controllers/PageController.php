<?php

namespace App\Http\Controllers;

use App\Support\Content;

class PageController extends Controller
{
    public function home()
    {
        return view('sport', ['p' => Content::all()]);
    }

    public function sitemap()
    {
        $lastmod = date('Y-m-d', @filemtime(storage_path('app/content/profile.json')) ?: time());
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n"
            . '  <url>' . "\n"
            . '    <loc>' . e(url('/')) . '</loc>' . "\n"
            . '    <lastmod>' . $lastmod . '</lastmod>' . "\n"
            . '    <changefreq>weekly</changefreq>' . "\n"
            . '    <priority>1.0</priority>' . "\n"
            . '  </url>' . "\n"
            . '</urlset>' . "\n";

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
