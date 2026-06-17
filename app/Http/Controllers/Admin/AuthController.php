<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminAccount;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (! AdminAccount::exists()) {
            return redirect()->route('admin.setup');
        }
        if (request()->session()->get('admin_authed')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        if (! AdminAccount::verify($data['email'], $data['password'])) {
            return back()->withErrors(['email' => 'Email or password is incorrect.'])->withInput(['email' => $data['email']]);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authed', true);

        return redirect()->route('admin.dashboard');
    }

    public function showSetup()
    {
        if (AdminAccount::exists()) {
            return redirect()->route('admin.login');
        }
        return view('admin.setup');
    }

    public function setup(Request $request)
    {
        if (AdminAccount::exists()) {
            return redirect()->route('admin.login');
        }

        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        AdminAccount::create($data['email'], $data['password']);

        $request->session()->regenerate();
        $request->session()->put('admin_authed', true);

        return redirect()->route('admin.dashboard')->with('ok', 'Admin account created. Welcome!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authed');
        $request->session()->regenerate();
        return redirect()->route('admin.login');
    }
}
