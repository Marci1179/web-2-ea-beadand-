<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // rendezés (mint a CRUD oldalon)
        $allowed = ['id','name','email','role','created_at'];
        $sort = in_array($request->get('sort'), $allowed, true) ? $request->get('sort') : 'id';
        $dir  = $request->get('dir') === 'desc' ? 'desc' : 'asc';

        $users = User::orderBy($sort, $dir)
            ->paginate(10)
            ->appends(['sort'=>$sort,'dir'=>$dir]);

        return view('admin', [
            'users'       => $users,
            'totalUsers'  => User::count(),
            'admins'      => User::where('role','admin')->count(),
            'registered'  => User::where('role','user')->count(),
            'sort'        => $sort,
            'dir'         => $dir,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|min:2',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'role'     => 'required|in:visitor,user,admin',
            'password' => 'nullable|string|min:6',
        ]);

        // ne veszítsük el az utolsó admint
        if ($user->role === 'admin' && ($validated['role'] ?? 'admin') !== 'admin') {
            if (User::where('role','admin')->count() <= 1) {
                return back()->with('error','Az utolsó admin szerepe nem módosítható!')
                             ->withInput();
            }
        }
        // ne vegyük le az admin szerepet
        if ($user->id === $request->user()->id && ($validated['role'] ?? $user->role) !== 'admin') {
            return back()->with('error','Saját fiókról nem veheted le az admin szerepet.')
                         ->withInput();
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];
        if (!empty($validated['password'])) {
            $user->password = $validated['password']; // mutátor hash-eli
        }
        $user->save();

        // vissza ugyanarra az oldalra + sorrenddel/pagel-lel
        return redirect()->route('admin.dashboard', $request->only(['page','sort','dir']))
                         ->with('success','Felhasználó frissítve.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error','Saját fiókodat nem törölheted.');
        }
        if ($user->role === 'admin' && User::where('role','admin')->count() <= 1) {
            return back()->with('error','Az utolsó admin nem törölhető.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard', $request->only(['page','sort','dir']))
                         ->with('success','Felhasználó törölve.');
    }
}
