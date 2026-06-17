<?php

namespace App\Http\Controllers;

use App\Support\Content;

class PageController extends Controller
{
    public function home()
    {
        return view('sport', ['p' => Content::all()]);
    }
}
