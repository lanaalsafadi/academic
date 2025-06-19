<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
    
    public function Logout(){
    	Auth::logout();
    	return Redirect()->route('login');

    }


    
    
     public function editProfile()
     {  
         return view('admin.account.editprofile');  
     }

    public function updateProfile(Request $request)
    {
         
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255' , 
        'password' => 'nullable|min:8|confirmed', 
    ]);
    

   
    $admin = Auth::guard('admin')->user();
  
   
    $admin->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

 
    if ($request->filled('password')) {
        $admin->password = bcrypt($request->password);
        $admin->save();
    }

    return redirect()->route('admin.login')->with('success', 'Profile updated successfully.');
}

    public function changePassword(Request $request)
    {
       
        $request->validate([
            'current_password' => 'required|string|min:8', 
            'new_password' => 'required|string|min:8|confirmed', 
        ]);

        $admin = auth()->user(); 

        
        if (!password_verify($request->current_password, $admin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

      
        $admin->update([
            'password' => bcrypt($request->new_password), 
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
