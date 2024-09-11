<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Authentication passed
    //         return redirect()->intended('dashboard'); // or wherever you want to redirect
    //     }

    //     // Authentication failed
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    public function login(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Prepare the credentials array using only the username
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('dashboard'); // Redirect to the dashboard or intended route
        }

        // Authentication failed, redirect back with error
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
}
