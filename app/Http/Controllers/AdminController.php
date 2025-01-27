<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:manage.admin.menu', only: ['index']),
            new Middleware('permission:admin.add', only: ['create']),
            new Middleware('permission:admin.list', only: ['index']),
            new Middleware('permission:admin.edit', only: ['edit']),
            new Middleware('permission:admin.delete', only: ['delete']),

        ];

    }

    public function index(){

        $admins = User::orderBy('name','ASC')->get();

        return view('backend.define_admin.define_admin_all', compact('admins'));

    }

    public function create(){

        $roles = Role::orderBy('name','ASC')->get();

        return view('backend.define_admin.define_admin_add', compact('roles'));

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
            'role' => 'required'
        ]);

        if($validator->fails()){
            $notification = array(
                'message' => 'Please fill up the required field',
                'alert-type' => 'error'
            );

            return redirect()->back()->withErrors($validator)->withInput()->with($notification);
        }

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;
        $data->password = Hash::make($request->password);
        $data->save();
        $data->syncRoles($request->role);


        $notification = array(
            'message' => 'Admin Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all')->with($notification);

    }

    public function edit($id){

        $admin = User::find($id);

        if(is_null($admin)){
            $notification = array(
                'message' => 'Admin Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('admin.all')->with($notification);
        }

        $roles = Role::orderBy('name','ASC')->get();

        $hasRole = $admin->roles->pluck('name')->first();

        return view('backend.define_admin.define_admin_edit', compact('admin','roles','hasRole'));
    }

    public function update(Request $request){

        $id = $request->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|unique:users,username,'.$id,
            'role' => 'required'
        ]);

        if($validator->fails()){
            $notification = array(
                'message' => 'Please fill up the required field',
                'alert-type' => 'error'
            );

            return redirect()->back()->withErrors($validator)->withInput()->with($notification);
        }

        $data = User::find($id);

        if(is_null($data)){
            $notification = array(
                'message' => 'Admin Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('admin.all')->with($notification);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if($request->password){
            $validator = Validator::make($request->all(),[
                'password' => 'min:5',
                'confirm_password' => 'same:password'
            ]);

            if($validator->fails()){
                $notification = array(
                    'message' => 'Please fill up the required field',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validator)->withInput()->with($notification);
            }

            $data->password = Hash::make($request->password);
        }

        $data->save();

        $data->syncRoles($request->role);

        $notification = array(
            'message' => 'Admin Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all')->with($notification);

    }

    public function delete($id){

        $data = User::find($id);

        if(is_null($data)){
            $notification = array(
                'message' => 'Admin Not Found',
                'alert-type' => 'error'
            );

            return redirect()->route('admin.all')->with($notification);
        }

        $data->delete();

        $notification = array(
            'message' => 'Admin Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all')->with($notification);

    }

    public function dashboard(){

        $suppliers = Supplier::count();

        $customers = Customer::count();

        $units = Unit::count();

        $categories = Category::count();

        $products = Product::count();

        $purchases = Purchase::count();

        $current_month_start_date = Carbon::now()->startOfMonth()->toDateString(); // Get the start date of the current month
        $current_month_end_date = Carbon::now()->endOfMonth()->toDateString(); // Get the end date of the current month

        // dd($current_month_start_date, $current_month_end_date);

        $purchase_amount = Purchase::whereBetween('date',[$current_month_start_date,$current_month_end_date ])->sum('buying_price');

        $total_purchase_amount = Purchase::sum('buying_price');

        $monthly_payment = Payment::whereBetween('created_at',[$current_month_start_date,$current_month_end_date ])->sum('paid_amount');

        $total_payment = Payment::sum('paid_amount');

        $monthly_due = Payment::whereBetween('created_at',[$current_month_start_date,$current_month_end_date ])->sum('due_amount');

        $total_due = Payment::sum('due_amount');

        // dd($purchase_amount);

        $invoices = Invoice::count();

        $latest_payment = PaymentDetail::with('invoice')->latest()->take(5)->get();

        // dd($latest_payment);

        // dd($invoices);

        return view('admin.index',compact('suppliers','customers','units','categories','products','purchase_amount','total_purchase_amount','purchases','invoices','monthly_payment','total_payment','monthly_due','total_due','latest_payment'));

    }

    //
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function Profile(){
        $id = Auth::user()->id;

        $adminData = User::find($id);

        return view('admin.admin_profile_view', compact('adminData'));

    } // *** End

    public function EditProfile(){
        $id = Auth::user()->id;

        $editData = User::find($id);

        return view('admin.admin_profile_edit', compact('editData'));
    } // *** End

    public function StoreProfile(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if($request->file('profile_image')){
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();

            $file->move(public_path('upload/admin_images'),$filename);
            $data->profile_image = $filename;
        }
        $data->save();

        return redirect()->route('admin.profile');

    } // *** End

    public function ChangePassword(){

        return view('admin.admin_change_password');

    } // *** End

    public function UpdatePassword(Request $request){

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword'
        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->oldpassword, $hashedPassword)){
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->newpassword);
            $user->save();

            session()->flash('message','Password Updated Successfully');

            return redirect()->back();
        }else{
            session()->flash('message','Old password is not match');

            return redirect()->back();
        }


    }


}
