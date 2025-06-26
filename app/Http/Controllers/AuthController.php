<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function login(Request $request){
        $credentials = $request->only('npk', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if (strtolower($user->name) === 'ehs') {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('form');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
