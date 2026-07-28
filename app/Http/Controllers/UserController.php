<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeUserManagement();

        $users = User::orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorizeUserManagement();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $data['password_plain'] = $data['password'];
        $data['password'] = Hash::make($data['password']);
        $data['is_admin'] = $request->has('is_admin');

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeUserManagement($user);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'is_admin' => ['nullable', 'boolean'],
            'old_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // If user provided old_password and is updating their own account, verify it matches
        $currentUser = Auth::user();
        if ($request->filled('old_password') && $currentUser && $currentUser->id === $user->id) {
            if (!Hash::check($request->input('old_password'), $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak cocok.'])->withInput();
            }
        }

        if ($request->filled('password')) {
            $data['password_plain'] = $request->input('password');
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // remove old_password from data so it is not mass assigned
        if (isset($data['old_password'])) {
            unset($data['old_password']);
        }

        $data['is_admin'] = $request->has('is_admin');

        $user->fill($data);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeUserManagement($user);

        if (Auth::user()->id === $user->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function authorizeUserManagement(?User $user = null): void
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            abort(403);
        }

        if ($currentUser->is_admin) {
            return;
        }

        if ($user && $user->id === $currentUser->id) {
            return;
        }

        abort(403);
    }
}
