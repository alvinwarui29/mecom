<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use Illuminate\Support\Facades\Auth;
class VendorController extends Controller

{
    //get home request
    public function VendorDashboard(){
        return view('vendor.index');
    }
    public function VendorDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }
    public function VendorLogin(){
        return view ('vendor.vendor_login');
    }

    public function VendorProfile(){
        $id = Auth::user()->id;
        $vendorData = User::find($id);
        return view ('vendor.vendor_profile',compact('vendorData'));
    }
    public function VendorProfileStore(Request $req){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address = $req->address;

        if($req->file('photo')){
            $file = $req->file('photo');
            @unlink(public_path('upload/vendor_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/vendor_images'),$filename);
            $data['photo'] = $filename;
        }
        $notification = array(
            'message'=>'Updated successfully',
            'alert-type'=>'success',
        );
        $data->save();
        return redirect()->back()->with($notification);
    }

    public function VendorchangePass(){
        return view ('vendor.vendor_change_password');
    }


    public function VendorUpdatePass(Request $req){
        $req->validate([
            'old_password'=>'required',
            'new_password'=>'required|confirmed',
        ]);
        if(!Hash::check($req->old_password,Auth::user()->password)){
            return redirect()->back()->with('error','Sorry! your current password does not match');
        }
        if(Hash::check($req->old_password,$req->new_password)){
            return redirect()->back()->with('error','Sorry! your new password should not be same as current password');
        }
        User::whereId(Auth()->user()->id)->update([
            'password'=>Hash::make($req->new_password)
        ]);
        return back()->with('status','password changed successfully');


    }


    public function BecomeVendor(){
        return view('auth.become_vendor');
    }//end method


    public function VendorRegister(Request $request) {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::insert([ 
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'vendor_join' => $request->vendor_join,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',
        ]);

          $notification = array(
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.login')->with($notification);

    }// End Mehtod 

}
