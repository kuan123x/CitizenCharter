<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::with('roles', 'office')->get();
    //     $roles = Role::all();
    //     $offices = Office::all();

    //     return view('admin.users_list', compact('users', 'roles', 'offices'));
    // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'username' => 'required|string|max:255|unique:users,username,' . $request->user_id,
    //         'password' => $request->user_id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
    //         'role' => 'required|exists:roles,name',
    //         'office_id' => 'nullable|exists:offices,id',
    //     ]);

    //     $user = User::updateOrCreate(
    //         ['id' => $request->user_id],
    //         [
    //             'username' => $validatedData['username'],
    //             'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : null,
    //         ]
    //     );

    //     $user->syncRoles([$validatedData['role']]);
    //     $user->office_id = $validatedData['role'] === 'head' ? $validatedData['office_id'] : null;
    //     $user->save();

    //     return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    // }

    // public function edit($id)
    // {
    //     $user = User::with('roles', 'office')->findOrFail($id);
    //     return response()->json($user);
    // }

    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    // }

    // public function mvmsp() {
    //     return view('pages.mvmsp');
    // }

    public function index()
    {
        $users = User::with('roles', 'office')->get();
        $roles = Role::all();
        $offices = Office::all();

        return view('admin.users_list', compact('users', 'roles', 'offices'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $request->user_id,
            'password' => $request->user_id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'office_id' => 'nullable|exists:offices,id',
        ]);

        $user = User::updateOrCreate(
            ['id' => $request->user_id],
            [
                'username' => $validatedData['username'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : null,
            ]
        );

        $user->syncRoles([$validatedData['role']]);
        $user->office_id = $validatedData['role'] === 'head' ? $validatedData['office_id'] : null;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Add the update method to handle PUT/PATCH requests
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'office_id' => 'nullable|exists:offices,id',
        ]);

        $user = User::findOrFail($id);
        $user->username = $validatedData['username'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->syncRoles([$validatedData['role']]);
        $user->office_id = $validatedData['role'] === 'head' ? $validatedData['office_id'] : null;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function edit($id)
    {
        $user = User::with('roles', 'office')->findOrFail($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
