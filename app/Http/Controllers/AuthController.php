<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' ? redirect('/admin') : redirect('/dashboard');
        }
        $request->session()->regenerateToken();
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required|string', // Student: full name, Admin: email or username
            'password' => 'required|string', // Student: NISN, Admin: password
        ]);

        $identity = $request->identity;
        $password = $request->password;

        if (Auth::attempt(['role' => 'student', 'name' => $identity, 'password' => $password])) {
            $request->session()->regenerate();
            return Auth::user()->role === 'admin' ? redirect('/admin') : redirect('/dashboard');
        }

        if (Auth::attempt(['role' => 'admin', 'username' => $identity, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        if (Auth::attempt(['role' => 'admin', 'email' => $identity, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->withErrors([
            'identity' => 'Nama atau NISN tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
