<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function UnitAll(){

        $units = Unit::latest()->get();

        return view('backend.unit.unit_all',compact('units'));

    }

    public function UnitAdd(){
        return view('backend.unit.unit_add');
    }

    public function UnitStore(Request $request){

        Unit::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Unit Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('unit.all')->with($notification);

    }

    public function UnitEdit($id){

        $unit = Unit::findOrFail($id);

        return view('backend.unit.unit_edit',compact('unit'));

    }

    public function UnitUpdate(Request $request){

        $unit_id = $request->id;

        Unit::findOrFail($unit_id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Unit Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('unit.all')->with($notification);
    }

    public function UnitDelete($id){

        Unit::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Unit Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
