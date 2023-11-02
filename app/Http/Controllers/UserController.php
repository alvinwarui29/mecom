<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function UserDashboard(){

        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('index',compact('userData'));

    } // End Method 

    public function UserProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// end method


    public function UserDestroy(Request $request): RedirectResponse
        {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }// end method


    public function UserUpdatePass(Request $req){
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
    } // end method
}
