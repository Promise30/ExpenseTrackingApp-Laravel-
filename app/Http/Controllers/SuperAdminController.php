<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    //
    public function index()
    {
        $currentUserId = auth()->user()->id;    
        $users = User::with('roles')->where('id', '!=', $currentUserId)->get(['id', 'name', 'email']);
        return view('admin.superadmin-dashboard', compact('users'));
        
    }
    public function assignRole(User $user)
    {
        return view('admin.assignRole', compact('user'));
    }
    public function storeAssignedRole(AssignRoleRequest $request)
    {
        $validatedData = $request->validated();
        $roleName = $validatedData['role'];
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);

        $role = Role::where('name', $roleName)->firstOrFail();
        if ($user->roles->contains($role->id)) {
            session()->flash('message', 'The user already has the selected role.');
        } else {
            $user->roles()->attach($role->id);
            session()->flash('success', 'Role assigned successfully.');
        }
        return redirect()->route('assignRole', ['user' => $user->id]);
    }
}
