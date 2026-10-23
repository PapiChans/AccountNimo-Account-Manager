<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function index(Request $request) {
        return view('index');
    }

    public function login(Request $request) {
        return view('auth.login');
    }

    
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = strtolower(trim($request->username));
        $ip = $request->ip();

        $key = 'login:' . $username . '|' . $ip;
        $ipKey = 'login-ip:' . $ip;

        $maxAttempts = 5;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($ipKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($ipKey);

            return back()->withErrors([
                'username' => "Too many failed login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('username');
        }

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'username' => "Too many failed login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('username');
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key);

            $request->session()->regenerate();
            $user = Auth::user();

            Logs::create([
                'user_id' => $user->id,
                'action' => 'Log In Success',
                'description' => 'Log In Successfully',
                'ip_address' => $ip,
                'created_at' => now(),
            ]);

            return redirect('/user/dashboard');
        }

        RateLimiter::hit($key, $decaySeconds);
        RateLimiter::hit($ipKey, $decaySeconds);

        $user = User::where('username', $request->username)->first();

        Logs::create([
            'user_id' => $user?->id,
            'action' => 'Log In Failed',
            'description' => 'Log In Failure',
            'ip_address' => $ip,
            'created_at' => now(),
        ]);

        if (
            RateLimiter::tooManyAttempts($ipKey, $maxAttempts) ||
            RateLimiter::tooManyAttempts($key, $maxAttempts)
        ) {
            $seconds = max(
                RateLimiter::availableIn($ipKey),
                RateLimiter::availableIn($key)
            );

            return back()->withErrors([
                'username' => "Too many failed login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    public function register(Request $request) {
        return view('auth.register');
    }

    public function registerCheckEmail(Request $request) {
        $query = User::where('email', $request->email);
        // Checking
        $exists = $query->exists();

        return response()->json(!$exists);
    }

    public function registerCheckUsername(Request $request) {
        $query = User::where('username', $request->account_username);
        // Checking
        $exists = $query->exists();

        return response()->json(!$exists);
    }

    public function registerStore(Request $request) {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->account_username,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            DB::commit();

            $notification = [
                'message' => 'User created successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('login')
                ->with('notification', $notification);
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal Server Error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {

        $user = Auth::user();

        Logs::create([
            'user_id' => $user->id,
            'action' => 'Log Out',
            'description' => 'Logged Out Successfully',
            'ip_address' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
