<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CustomerController extends Controller
{

    public function CustomerAll(){

        $customers = Customer::latest()->get();

        return view('backend.customer.customer_all',compact('customers'));

    } // todo: End Method

    public function CustomerAdd(){

        return view('backend.customer.customer_add');

    } // todo: End Method

    public function CustomerStore(Request $request){

        $image = $request->file('customer_image');

        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        $path = public_path('upload/customer/'.$name_gen);

        $manager = new ImageManager(new Driver());

        $imageInt = $manager->read($image);

        $imageInt->resize(200,200);

        $imageInt->save($path);

        $save_url = 'upload/customer/'.$name_gen;

        Customer::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);

    } // todo: End Method

    public function CustomerEdit($id){

        $customer = Customer::findOrFail($id);

        return view('backend.customer.customer_edit',compact('customer'));

    } // todo: End Method

    public function CustomerUpdate(Request $request){

        $customer_id = $request->id;

        if($request->file('customer_image')){

            // todo: Delete Old Image
            $customer = Customer::select('customer_image')->where('id',$customer_id)->first();

            $old_image = $customer->customer_image;

            if(file_exists($old_image)){
                unlink($old_image);
            }else{
                echo "File does not exist";
            }


            $image = $request->file('customer_image');

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            $path = public_path('upload/customer/'.$name_gen);

            $manager = new ImageManager(new Driver());

            $imageInt = $manager->read($image);

            $imageInt->resize(200,200);

            $imageInt->save($path);

            $save_url = 'upload/customer/'.$name_gen;

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated With Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);

        }else{

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);

        }

    } // todo: End Method

    public function CustomerDelete($id){

        $customer = Customer::findOrFail($id);

        $old_img = $customer->customer_image;

        if(file_exists($old_img)){
            unlink($old_img);
        }

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // todo: End Method

}
