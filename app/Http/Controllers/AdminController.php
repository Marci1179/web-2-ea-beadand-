<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Alap: felhasználók listája (név, email, szerep)
        $users = User::orderBy('role','desc')->orderBy('name')->paginate(10);

        return view('admin', [
            'users' => $users,
            'totalUsers' => User::count(),
            'admins' => User::where('role','admin')->count(),
            'registered' => User::where('role','user')->count(),
        ]);
    }
}
