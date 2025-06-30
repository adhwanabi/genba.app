<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

    public function showRegisterForm()
    {
        return view('auth.register'); // Make sure to create this view file
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'npk' => 'required|string|unique:users,npk|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'npk' => $validatedData['npk'],
            'email' => strtolower(str_replace(' ', '', $validatedData['name'])) . '@gmail.com',
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
