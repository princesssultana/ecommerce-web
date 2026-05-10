<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register page দেখাও
    public function registerPage()
    {
        return view('frontend.pages.register');
    }

    // Register করো
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
           
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // register করেই login করিয়ে দাও

        return redirect('/')->with('success', 'Registration successful!');
    }

    // Login page দেখাও
    public function loginPage()
    {
        return view('frontend.pages.login');
    }

    // Login করো
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // login সফল
            return redirect('/')->with('success', 'Welcome back!');
        }

        // login ব্যর্থ
        return redirect()->back()->with('error', 'Email or password is incorrect!');
    }

    // Logout করো
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}