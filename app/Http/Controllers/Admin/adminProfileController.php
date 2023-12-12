<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class adminProfileController extends Controller
{
    public function adminPrifileEdit(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.profile.edit', compact('adminData'));
    } /// End Method

    public function adminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->last_name = $request->last_name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }
        $data->save();
        $notification = [
            'message' => 'Admin profile update successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    } /// End Method

    public function adminSetting(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.profile.setting', compact('adminData'));
    } /// End Method

    public function adminPasswordStore(Request $request){
        // Validation 
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed', 
        ]);

        // Match The Old Password
        if (!Hash::check($request->current_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!");
        }

        // Update The new password 
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);
        return back()->with("status", " Password Changed Successfully");
    } /// End Method
}
