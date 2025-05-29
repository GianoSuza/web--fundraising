<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showSignIn()
    {
        return view('auth.sign-in');
    }

    public function showSignUp()
    {
        return view('auth.sign-up');
    }

    public function signIn(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Logic untuk autentikasi user
        // Untuk sementara, redirect ke dashboard
        // Dalam implementasi nyata, gunakan Auth::attempt()
        
        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }

    public function signUp(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'country' => 'required|string',
            'phone' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'agree_to_terms' => 'required|accepted',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'country.required' => 'Please select your country',
            'phone.required' => 'Phone number is required',
            'gender.required' => 'Please select your gender',
            'agree_to_terms.accepted' => 'You must agree to the Terms of Service and Privacy Policy',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Logic untuk membuat user baru
        // Dalam implementasi nyata, simpan ke database
        
        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    public function logout()
    {
        // Logic untuk logout
        // Auth::logout();
        return redirect()->route('sign-in')->with('success', 'You have been logged out successfully');
    }
}
