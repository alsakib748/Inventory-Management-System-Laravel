<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
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
