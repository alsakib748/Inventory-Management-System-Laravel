<?php

namespace App\Http\Controllers\Pos;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class SupplierController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:manage.supplier.menu', only: ['SupplierAll']),
            new Middleware('permission:supplier.add', only: ['SupplierAdd']),
            new Middleware('permission:supplier.list', only: ['SupplierAll']),
            new Middleware('permission:supplier.edit', only: ['SupplierEdit']),
            new Middleware('permission:supplier.delete', only: ['SupplierDelete']),

        ];

    }

    public function SupplierAll(){

        $suppliers = Supplier::latest()->get();

        return view('backend.supplier.supplier_all',compact('suppliers'));

    } // todo: End Method

    public function SupplierAdd(){

        return view('backend.supplier.supplier_add');

    } // todo: End Method

    public function SupplierStore(Request $request){

        Supplier::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);

    } // todo: End Method

    public function SupplierEdit($id){

        $supplier = Supplier::findOrFail($id);

        return view('backend.supplier.supplier_edit',compact('supplier'));

    } // todo: End Method

    public function SupplierUpdate(Request $request){

        $supplier_id = $request->id;

        Supplier::findOrFail($supplier_id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);

    } // todo: End Method

    public function SupplierDelete($id){

        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
