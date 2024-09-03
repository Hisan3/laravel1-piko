<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    function role_manager(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('backend.role.role', [
            'permissions' => $permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }

    function permission_store(Request $request){
        Permission::create(['name' =>$request->permission_name]);
        return back()->with('success', 'Permission Added!!');
    }

    function add_role(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back()->with('role_success', 'Role Added!!');

    }

    function del_role($role_id){
        Role::find($role_id)->delete();
        DB::table('role_has_permissions')->where('role_id', $role_id)->delete();
        return back();
    }

    function assign_role(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role_name);
        return back();
    }

    function remove_role($user_id){
        $user = User::find($user_id);
        $user ->syncRoles([]);
        return back();
    }
}
