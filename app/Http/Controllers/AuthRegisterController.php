<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'phone_number' => 'nullable|string',
                'birth_date' => 'required|date',
            ]);

            $user = User::create($fields);

            $token = $user->createToken($request->name);


            // Api Handling
            if ($request->expectsJson()) {
                // API response
                return response()->json([
                    'user' => $user,
                    'token' => $token->plainTextToken,
                ]);
            }

            // Web app: Authenticate and redirect
            Auth::login($user);
            return redirect()->intended('/dashboard');

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Handle Api Request
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed!',
                    'errors' => $e->errors(),
                ], 422);
            }

            // Web App
            return back()->withErrors(['error' => 'Gagal mendaftar, periksa input Anda!']);
        }

    }

    public function login(Request $request)
    {

        $request->validate([
            'identifier'=> 'required|string',
            'password' => 'required'
        ]);

        $user = User::where('email',$request->identifier)
                ->orWhere('name',$request->identifier)
                ->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            if ($request->expectsJson()) {
                // API response
                return response()->json([
                    'message' => 'The provided credentials are incorrect!',
                ], 401);
            }

            // Web app: Redirect back with error
            return back()->withErrors(['error' => 'The provided credentials are incorrect!']);
        }

        $token = $user->createToken($user->name);

        // Handle Api Request If Accepted
        if ($request->expectsJson()) {
            // API response
            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken,
            ]);
        }

        // Web App If Accepted
        Auth::login($user);
        session(['auth_token' => $token]);
        return redirect()->intended('/dashboard');

    }

    public function logout(Request $request)
    {
        // API Request Handling
        if ($request->expectsJson()) {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged Out.']);
        }

        // Web app: Logout and clear session
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }
        Auth::logout();

        // Forget Token Only for This Session
        // session()->forget('auth_token');

        // Fully Delete Token From Databases
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/');
    }
}
