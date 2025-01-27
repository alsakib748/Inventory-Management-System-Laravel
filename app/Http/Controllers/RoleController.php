<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:all.role.submenu', only: ['index']),
            new Middleware('permission:all.role.add', only: ['create']),
            new Middleware('permission:all.role.list', only: ['index']),
            new Middleware('permission:all.role.edit', only: ['edit']),
            new Middleware('permission:all.role.delete', only: ['destroy']),

            // new Middleware('permission:all.role.has.permission.delete', only: ['delete']),

        ];

    }


    public function index()
    {

        $roles = Role::orderby('name' , 'asc')->get();

        return view('backend.roles_and_permissions.role.role_all',compact('roles'));

    }

    public function create()
    {

        return view('backend.roles_and_permissions.role.role_add');

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'role_name' => 'required|min:3|max:50',
        ]);

        if($validator->passes()){

            $role = new Role();
            $role->name = $request->role_name;
            $role->save();

            $notification = array(
                'message' => 'Role Added Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('roles')->with($notification);

        }
        else{

            $notification = array(
                'message' => 'Please. Fill up the required field',
                'alert-type' => 'error'
            );

            return redirect()->route('roles.create')->with($notification);

        }

    }

    public function edit(string $id)
    {

        $role = Role::find($id);

        if(is_null($role)){

            $notification = array(
                'message' => 'Role Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('roles')->with($notification);

        }

        return view('backend.roles_and_permissions.role.role_edit',compact('role'));

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $role = Role::findOrFail($id);

        if(is_null($role)){
            $notification = array(
                'message' => 'Role Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('roles')->with($notification);
        }

        $validator = Validator::make($request->all(),[
            'role_name' => 'required|min:3|max:50',
        ]);

        if($validator->passes()){

            $role->name = $request->role_name;
            $role->save();

            $notification = array(
                'message' => 'Role Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('roles')->with($notification);

        }
        else{

            $notification = array(
                'message' => 'Please. Fill up the required field',
                'alert-type' => 'error'
            );

            return redirect()->route('roles.edit',$id)->with($notification);

        }

    }


    public function destroy(string $id)
    {

        $role = Role::find($id);

        if(is_null($role)){

            $notification = array(
                'message' => 'Role Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('roles')->with($notification);

        }

        $role->delete();

        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles')->with($notification);

    }

}
