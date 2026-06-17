<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Analytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $days = (int) $request->query('days', 30);
        if (! in_array($days, [7, 30, 90, 0], true)) {
            $days = 30;
        }

        return view('admin.analytics', [
            'days' => $days,
            'data' => Analytics::summary($days),
        ]);
    }
}
