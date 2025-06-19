<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SupportAuthController extends Controller
{
    //
    public function index()
    {
      

     
       if (!Auth::guard('support')->check()) {
  
        return Redirect()->route('support.login');
    }
        return view('support.index'); 
    }
    public function showLoginForm()
    {
        return view('auth.support.login');
    }

    public function login(Request $request)
    {   
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8', 
        ]
       ,[
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف.',
        ]  
    );
        $credentials = $request->only('email', 'password');

        if (Auth::guard('support')->attempt($credentials)) {
            return redirect()->route('support.dashboard');
        }

        return back()->withErrors(['error' => 'Invalid credentials'])->withInput();
    }
    public function Logout(){
    	Auth::guard('support')->logout();
        session()->flush(); // سيحذف كل بيانات الجلسة
    	return Redirect()->route('support.login');

    }
}
