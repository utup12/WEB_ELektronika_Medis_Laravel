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
    public function showLogin(): View
    {
        return view('masuk');
    }

    public function roleLoginForm(string $role): View
    {
        return view('login-peran', ['role' => $role]);
    }

    public function showRegister(): View
    {
        return view('daftar');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'password' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:student,lecturer'],
        ]);

        if (! Auth::attempt(['name' => $data['name'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()
                ->withErrors(['login' => 'Nama atau kata sandi tidak sesuai.'])
                ->onlyInput('name');
        }

        $user = $request->user();

        if ($user->isLecturer() !== ($data['role'] === 'lecturer')) {
            // Do not leave a half-authenticated session behind on a role mismatch.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Akun ini tidak sesuai dengan jenis akses yang dipilih.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:users,name'],
            'password' => ['required', 'confirmed', 'min:8', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => Str::slug($data['name']).'.'.Str::lower(Str::random(10)).'@local.invalid',
            'password' => Hash::make($data['password']),
            'role' => 'student',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
