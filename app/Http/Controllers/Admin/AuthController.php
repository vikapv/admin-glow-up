<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Показываем форму входа
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::guard('admin')->attempt(
        $request->only('email', 'password'),
        $request->filled('remember')
    )) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'login_error' => 'Неверный email или пароль',
    ])->withInput($request->only('email'));
}

public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
}
}
