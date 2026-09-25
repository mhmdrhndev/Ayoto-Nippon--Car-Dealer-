<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'branch'])->orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(),
            'roles' => Role::orderBy('name')->get(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'telp' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'branch_id' => $data['branch_id'] ?? null,
            'telp' => $data['telp'] ?? null,
        ]);
        $user->assignRole($data['role']);

        return redirect()->route('admin.users.index')->with('sukses', 'User berhasil ditambah.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user' => $user,
            'roles' => Role::orderBy('name')->get(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'telp' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'branch_id' => $data['branch_id'] ?? null,
            'telp' => $data['telp'] ?? null,
        ] + ($data['password'] ? ['password' => Hash::make($data['password'])] : []));
        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index')->with('sukses', 'User berhasil diperbarui.');
    }
}
