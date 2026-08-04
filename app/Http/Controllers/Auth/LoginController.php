<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $bgSource = 'C:/Users/appsdev/.gemini/antigravity-ide/brain/33d9b202-04a5-43fc-8a98-b61d3c9289a1/media__1785568992637.png';
        $targetDir = public_path('assets/images');
        if (file_exists($bgSource)) {
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            @copy($bgSource, $targetDir . '/admin-bg.jpg');
        }

        // Ensure default Super Admin exists with correct password
        $admin = \App\Models\User::where('email', 'admin@momentsstudio.in')->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name'              => 'Admin',
                'email'             => 'admin@momentsstudio.in',
                'password'          => 'Admin@123',
                'phone'             => '+91 98765 43210',
                'role'              => 'super_admin',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);
        } else {
            // Guarantee password Admin@123 is valid
            if (!\Illuminate\Support\Facades\Hash::check('Admin@123', $admin->password)) {
                $admin->password = 'Admin@123';
                $admin->email_verified_at = now();
                $admin->is_active = true;
                $admin->save();
            }
        }

        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Update last login details
            $user = Auth::user();
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
