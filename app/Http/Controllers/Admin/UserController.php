<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TAMPIL DATA USER
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = User::query();

        // SEARCH
        if ($request->search) {

            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('role', 'like', '%' . $request->search . '%');

        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH USER
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.users.create');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN USER
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        return redirect('/admin/users')
            ->with('success', 'User berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT USER
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required'
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role
        ]);

        return redirect('/admin/users')
            ->with('success', 'User berhasil diupdate');
    }

    
    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD USER
    |--------------------------------------------------------------------------
    */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        // Password default
        $defaultPassword = '12345678';

        $user->password = Hash::make($defaultPassword);

        $user->save();

        return redirect('/admin/users')
            ->with(
                'success',
                'Password berhasil direset menjadi: ' . $defaultPassword
            );
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }
}