<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:manage.product.menu', only: ['ProductAll']),
            new Middleware('permission:product.add', only: ['ProductAdd']),
            new Middleware('permission:product.list', only: ['ProductAll']),
            new Middleware('permission:product.edit', only: ['ProductEdit']),
            new Middleware('permission:product.delete', only: ['ProductDelete']),

        ];

    }

    public function ProductAll(){

        $products = Product::latest()->get();

        return view('backend.product.product_all',compact('products'));

    }

    public function ProductAdd(){

            $supplier = Supplier::orderBy('name','ASC')->get();

            $category = Category::orderBy('name','ASC')->get();

            $unit = Unit::orderBy('name','ASC')->get();

            return view('backend.product.product_add',compact('supplier','category','unit'));

    }

    public function ProductStore(Request $request){

        Product::insert([
            'name' => $request->name,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'quantity' => '0',
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product.all')->with($notification);

    }

    public function ProductEdit($id){

        $supplier = Supplier::orderBy('name','ASC')->get();

        $category = Category::orderBy('name','ASC')->get();

        $unit = Unit::orderBy('name','ASC')->get();

        $product = Product::findOrFail($id);

        return view('backend.product.product_edit',compact('supplier','category','unit','product'));

    }

    public function ProductUpdate(Request $request){

        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
            'name' => $request->name,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product.all')->with($notification);

    }

    public function ProductDelete($id){

        Product::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
