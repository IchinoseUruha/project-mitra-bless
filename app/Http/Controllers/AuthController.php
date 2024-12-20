<?php

namespace App\Http\Controllers;

use App\Models\User; // Gunakan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'mobile' => 'required|string|max:20|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Buat user di database Laravel
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'utype' => 'CUSTOMER_B', // Default role
        ]);
    
        try {
            // Perbaikan cara passing parameter
            DB::statement("CALL update_user_roles(?, ?, ?)", [
                $request->email,          // email dalam string
                $request->password,       // password asli
                'CUSTOMER_B'             // utype dalam string, sesuai dengan CASE statement
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to assign database roles: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to assign database roles.']);
        }
    
        Auth::login($user);
        return redirect()->route('home.index');
    }
    


    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan utype
        if(strcasecmp(Auth::user()->utype, 'ADMIN') === 0) {
            return redirect()->route('admin.index');
        }
        else if(strcasecmp(Auth::user()->utype, 'KARYAWAN') === 0) {
            return redirect()->route('kasir.index');
        }
        
            return redirect()->intended(route('home.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
