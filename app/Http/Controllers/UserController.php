<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use validate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
<<<<<<< HEAD
        try {
            $credentials = $request->validate([
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:6', 'max:50'],
            ], [
                'username.required' => 'Username is required.',
                'username.max'      => 'Username cannot exceed 255 characters.',

                'password.required' => 'Password is required.',
                'password.min'      => 'Password must be at least 6 characters long.',
                'password.max'      => 'Password cannot exceed 50 characters.',
            ]);

            // Attempt to login
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                $request->session()->regenerate();

                return redirect()->intended('admin/index')
                    ->with('success', 'Login successful!');
            }

            return back()->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ])->withInput();
        } catch (\Throwable $th) {
            return back()->withErrors([
                'login' => 'Something went wrong! Please try again later.',
            ])->withInput();
        }
    }

=======
          // Validate request input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Attempt to login
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $request->session()->regenerate();

            return redirect('admin/website-list');
        }
    }
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
<<<<<<< HEAD
=======

>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
}
