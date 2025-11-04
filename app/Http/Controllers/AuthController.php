<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // űrlapok
    public function showRegister() { return view('auth.register'); }
    public function showLogin()    { return view('auth.login'); }

    // regisztráció
    public function register(Request $request) {
        $validated = $request->validate([
            'name'     => 'required|string|min:2',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // új regisztrált alapból 'user' szerepkörrel
        $user = User::create([
            'name' => $validated['name'],
            'email'=> $validated['email'],
            'password' => $validated['password'], // User model hash-eli
            'role' => 'user',
        ]);

        Auth::login($user);
        return redirect()->route('login')->with('success','Sikeres regisztráció!');
    }

    // bejelentkezés
    public function login(Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('fooldal'))->with('success','Sikeres bejelentkezés!');
        }

        return back()->withErrors(['email'=>'Hibás email vagy jelszó'])->onlyInput('email');
    }

    // kijelentkezés
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success','Kijelentkeztél.');
    }
}