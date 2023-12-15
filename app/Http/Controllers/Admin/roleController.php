<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DB;

class roleController extends Controller
{
    public function permissionsAll(){
        return view('admin.pages.permissions.permission_all');
    } /// End Method

    public function storePermission(Request $request){
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
        $notification = [
            'message' => 'Permission Create Successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    } /// End Method

    public function rolesAll(){
        return view('admin.pages.roles.roles_all');
    } /// End Method

    public function storeRole(Request $request){
        Role::create([
            'name' => $request->name,
        ]);
        $notification = [
            'message' => 'Role Create Successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    } /// End Method

    public function addRolesAndPermissions(){
        $permissions = Permission::all();
        $roles = Role::all();
        $permissionGroups = User::permissionGroup();
        return view('admin.pages.permissions.add_roles_and_permissions', compact('permissions', 'roles', 'permissionGroups'));
    } /// End Method

    public function storeRoleAndPermission(Request $request){
        $permissions = $request->permission_id;
    
        foreach ($permissions as $key => $value) {
            $data[] = [
                'role_id' => $request->role_id,
                'permission_id' => $value,
            ];
        }
    
        // Use the createMany method to insert multiple records
        DB::table('role_has_permissions')->insert($data);
    
        $notification = [
            'message' => 'Role and permission created successfully!',
            'alert-type' => 'success'
        ];
    
        return redirect()->back()->with($notification);
    }
    
}
