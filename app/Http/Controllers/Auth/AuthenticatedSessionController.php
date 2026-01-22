<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */



public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    // === TAMBAHAN LOGIKA REDIRECT ===
    
    // 1. Cek Role User yang sedang login
    $role = $request->user()->role; 

    // 2. Jika Admin, arahkan ke route admin.dashboard
    if ($role === 'admin') {
        return redirect()->intended(route('admin.dashboard'));
    }

    // 3. Jika Mahasiswa, arahkan ke route dashboard (mahasiswa)
    if ($role === 'mahasiswa') {
        return redirect()->intended(route('dashboard'));
    }

    // 4. Default redirect jika tidak punya role khusus
    return redirect()->intended('/dashboard');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
