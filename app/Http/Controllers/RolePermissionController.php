<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RolePermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:all.role.has.permission.submenu', only: ['index']),
            new Middleware('permission:all.role.has.permission.list', only: ['index']),
            new Middleware('permission:all.role.has.permission.edit', only: ['edit']),
            new Middleware('permission:manage.role.permission.menu', only: ['index']),

            // new Middleware('permission:assign.permission.add', only: ['create']),
            // new Middleware('permission:assign.permission.submenu', only: ['index']),
            // new Middleware('permission:manage.role.permission.menu', only: ['edit']),

        ];

    }

    public function index(){

        $roles = Role::orderBy('name','asc')->get();

        return view('backend.roles_and_permissions.role_permission.role_permissions_all',compact('roles',));

    }

    public function create(){

        $roles = Role::orderBy('name','asc')->get();
        $groupPermissions = Permission::all()->groupBy('group_name');
        // $permissions = Permission::orderBy('name',direction: 'asc')->get();
        $permissions = Permission::all();
        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();

        // dd($permission_groups);

        // dd($groupPermissions);

        return view('backend.roles_and_permissions.role_permission.role_permissions_add',compact('roles','permissions','groupPermissions','permission_groups'));

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {

            $notification = array(
                'message' => 'Permission not added, Please fill up the field!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);

        }

        $role = Role::findById($request->role_id);

        foreach($request->permission as $name){
            $role->givePermissionTo($name);
        }

        $notification = array(
                'message' => 'Permission added successfully!',
                'alert-type' => 'success'
        );

        return redirect()->route('role.permissions')->with($notification);


    }

    public function edit($id){


        $hasRole = Role::find($id);

        if(is_null($hasRole)){
            $notification = array(
                'message' => 'Role not found!',
                'alert-type' => 'error'
            );

            return redirect()->route('role.permissions')->with($notification);
        }

        $roles = Role::orderBy('name','asc')->get();

        $hasPermissions = $hasRole->permissions->pluck('name');

        // dd($hasPermissions);

        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();

        return view('backend.roles_and_permissions.role_permission.role_permissions_edit',compact('roles','hasRole','hasPermissions','permission_groups'));

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,name'
        ]);

        if ($validator->fails()) {

            $notification = array(
                'message' => 'Permission not updated, Please fill up the field!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);

        }

        $role = Role::find($request->role_id);

        if($role == null){
            $notification = array(
                'message' => 'Role not found!',
                'alert-type' => 'error'
            );

            return redirect()->route('role.permissions')->with($notification);
        }

        $role->syncPermissions($request->permission);

        $notification = array(
                'message' => 'Permission updated successfully!',
                'alert-type' => 'success'
        );

        return redirect()->route('role.permissions')->with($notification);

    }



}
