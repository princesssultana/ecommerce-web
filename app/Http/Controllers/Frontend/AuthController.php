<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){
        return view ('frontend.pages.register');
    }

    // ── REGISTER SUBMIT ───────────────────────────
    public function submitRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Name is required',
            'email.required'     => 'Email is required',
            'email.unique'       => 'This email is already registered',
            'phone.required'     => 'Phone number is required',
            'password.min'       => 'Password must be at least 6 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        // User create করো
       $user = User::create([
    'name'     => $request->name,
    'email'    => $request->email,
    'phone'    => $request->phone,
    'password' => Hash::make($request->password),
    
            ]);

        // Register এর পরে auto login
        Auth::login($user);

        return redirect()
               ->route('products.list')
               ->with('success', 'Registration successful!');
    }

    public function showLogin(){
        return view ('frontend.pages.login');
    }

    // ── LOGIN SUBMIT ──────────────────────────────
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email is required',
            'email.email'       => 'Provide a valid email',
            'password.required' => 'Password is required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()
                  ->route('products.list')
                   ->with('success', 'Login successful!');
        }

        // Login fail
        return back()
               ->withErrors(['email' => 'Email or Password is incorrect'])
               ->withInput($request->only('email'));
    }

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('show.login');
}

}
