<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocalAuthController extends Controller
{
    public function loginForm(): View { return view('masuk'); }
    public function roleLoginForm(string $role): View { return view('login-peran', ['role' => $role]); }
    public function registerForm(): View { return view('daftar'); }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string'], 'password' => ['required', 'string'], 'role' => ['required', 'in:student,lecturer']]);
        if (! Auth::attempt(['name' => $data['name'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()->withErrors(['login' => 'Nama atau kata sandi tidak sesuai.'])->onlyInput('name');
        }
        if (! $request->user()->isLecturer() && $data['role'] === 'lecturer' || $request->user()->isLecturer() && $data['role'] === 'student') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini tidak sesuai dengan jenis akses yang dipilih.']);
        }
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120', 'unique:users,name'], 'password' => ['required', 'confirmed', 'min:8']]);
        $email = Str::slug($data['name']).'.'.Str::lower(Str::random(10)).'@local.invalid';
        $user = User::create(['name' => $data['name'], 'email' => $email, 'password' => Hash::make($data['password']), 'role' => 'student']);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
