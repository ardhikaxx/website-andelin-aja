<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    private const RESET_EMAIL_SESSION_KEY = 'password_reset_email';

    public function showLoginForm(): View|RedirectResponse
    {
        if ($redirect = $this->redirectAuthenticatedUser()) {
            return $redirect;
        }

        return view('auth.login');
    }

    public function showForgotPasswordForm(): View|RedirectResponse
    {
        if ($redirect = $this->redirectAuthenticatedUser()) {
            return $redirect;
        }

        return view('auth.forgot-password');
    }

    public function verifyForgotPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()->withInput()->with('error', 'Email tidak dapat dikenali oleh sistem.');
        }

        $request->session()->put(self::RESET_EMAIL_SESSION_KEY, $user->email);

        return redirect()->route('password.reset');
    }

    public function showResetPasswordForm(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->redirectAuthenticatedUser()) {
            return $redirect;
        }

        $email = $request->session()->get(self::RESET_EMAIL_SESSION_KEY);

        if (! $email) {
            return redirect()->route('password.request')->with('error', 'Silakan verifikasi email terlebih dahulu.');
        }

        if (! User::where('email', $email)->exists()) {
            $request->session()->forget(self::RESET_EMAIL_SESSION_KEY);

            return redirect()->route('password.request')->with('error', 'Email tidak dapat dikenali oleh sistem.');
        }

        return view('auth.reset-password', [
            'email' => $email,
        ]);
    }

    public function updateForgotPassword(Request $request): RedirectResponse
    {
        $email = $request->session()->get(self::RESET_EMAIL_SESSION_KEY);

        if (! $email) {
            return redirect()->route('password.request')->with('error', 'Silakan verifikasi email terlebih dahulu.');
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $email)->first();

        if (! $user) {
            $request->session()->forget(self::RESET_EMAIL_SESSION_KEY);

            return redirect()->route('password.request')->with('error', 'Email tidak dapat dikenali oleh sistem.');
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        $request->session()->forget(self::RESET_EMAIL_SESSION_KEY);

        return redirect()->route('login')->with('success', 'Password baru berhasil disimpan. Silakan login kembali.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withInput()->with('error', 'Email atau password tidak valid.');
        }

        $request->session()->regenerate();

        return $this->authenticated($request, $request->user());
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('employee.home');
    }

    private function redirectAuthenticatedUser(): ?RedirectResponse
    {
        if (! auth()->check()) {
            return null;
        }

        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('employee.home');
    }
}