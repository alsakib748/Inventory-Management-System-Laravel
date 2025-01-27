<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:all.permission.submenu', only: ['index']),
            new Middleware('permission:all.permission.add', only: ['create']),
            new Middleware('permission:all.permission.list', only: ['index']),
            new Middleware('permission:all.permission.edit', only: ['edit']),
            new Middleware('permission:all.permission.delete', only: ['destroy']),

            new Middleware('permission:assign.permission.add', only: ['create']),
            new Middleware('permission:assign.permission.submenu', only: ['index']),


        ];

    }

    public function index()
    {

        $permissions = Permission::orderby('name' , 'asc')->get();

        return view('backend.roles_and_permissions.permission.permission_all',compact('permissions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backend.roles_and_permissions.permission.permission_add');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'group_name' => 'required|min:3|max:50',
            'name' => 'required|min:3|max:50',
        ]);

        if($validator->passes()){

            $permission = new Permission();
            $permission->group_name = $request->group_name;
            $permission->name = $request->name;
            $permission->save();

            $notification = array(
                'message' => 'Permission Added Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('permissions')->with($notification);

        }
        else{

            $notification = array(
                'message' => 'Please. Fill up the required field',
                'alert-type' => 'error'
            );

            return redirect()->route('permissions.create')->with($notification);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $permission = Permission::find($id);

        if(is_null($permission)){

            $notification = array(
                'message' => 'Permission Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('permissions')->with($notification);

        }

        return view('backend.roles_and_permissions.permission.permission_edit',compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $id = $request->id;

        $permission = Permission::findOrFail($id);

        if(is_null($permission)){
            $notification = array(
                'message' => 'Permission Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('permissions')->with($notification);
        }

        $validator = Validator::make($request->all(),[
            'group_name' => 'required|min:3|max:50',
            'name' => 'required|min:3|max:50',
        ]);

        if($validator->passes()){

            $permission->group_name = $request->group_name;
            $permission->name = $request->name;
            $permission->save();

            $notification = array(
                'message' => 'Permission Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('permissions')->with($notification);

        }
        else{

            $notification = array(
                'message' => 'Please. Fill up the required field',
                'alert-type' => 'error'
            );

            return redirect()->route('permissions.edit',$id)->with($notification);

        }

    }


    public function destroy(string $id)
    {

        $permission = Permission::find($id);

        if(is_null($permission)){

            $notification = array(
                'message' => 'Permission Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('permissions')->with($notification);

        }

        $permission->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permissions')->with($notification);

    }
}
