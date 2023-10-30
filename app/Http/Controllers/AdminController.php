<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    //get request
    public function AdminDashboard(){
        return view('admin.index');
    }

    //login
    public function AdminLogin(){
        return view ('admin.admin_login');
    }
    //logout
    public function AdminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    //view profile
    public function AdminProfile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    }

    //profile store
    public function AdminProfileStore(Request $req){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address = $req->address;
        if($req->file('photo')){
            $file = $req->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;

        }
        $notification = array(
            'message'=>'Updated successfully',
            'alert-type'=>'success',
        );
        $data->save();
        return redirect()->back()->with($notification);

    }
    public function AdminChangePassword(){
        return view ('admin.admin_change_password');
    }
    public function AdminUpdatePass(Request $req){
        $req -> validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        if(!Hash::check($req->old_password,Auth::user()->password)){
            return redirect()->back()->with('error','Sorry! your old password does not match');

        }
        if(Hash::check($req->new_password,Auth::user()->password)){
            return redirect()->back()->with('error','Sorry! your new password should not be same as old password');

        }
        User::whereId(Auth()->user()->id)->update([
            'password' => Hash::make($req->new_password)
        ]);
        return back()->with('status','password changed successfully');
    }
}
