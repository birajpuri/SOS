<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|max:100|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            //Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'You are logged in');
        }
        //if auth fails, redirect back
        return back()->withErrors([
            'email' => 'The provided credentials donot match our records'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
