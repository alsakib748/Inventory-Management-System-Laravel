<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [
            new Middleware('permission:manage.category.menu', only: ['CategoryAll']),
            new Middleware('permission:category.list', only: ['CategoryAll']),
            new Middleware('permission:category.edit', only: ['CategoryEdit']),
            new Middleware('permission:category.add', only: ['CategoryStore']),
            new Middleware('permission:category.delete', only: ['CategoryDelete']),
        ];

    }

    public function CategoryAll(){

        $categories = Category::latest()->get();

        return view('backend.category.category_all',compact('categories'));

    }

    public function CategoryAdd(){
        return view('backend.category.category_add');
    }

    public function CategoryStore(Request $request){

        Category::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Category Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);

    }

    public function CategoryEdit($id){

        $category = Category::findOrFail($id);

        return view('backend.category.category_edit',compact('category'));
    }

    public function CategoryUpdate(Request $request){

        $category_id = $request->id;

        Category::findOrFail($category_id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);

    }

    public function CategoryDelete($id){

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
