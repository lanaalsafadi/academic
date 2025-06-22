<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\ASupport;
class AdminAuthController extends Controller
{
    //
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
           
            return Redirect()->route('admin.login');
            
        }
 
        return view('admin.index');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login'); 
    }

    public function login(Request $request)
    {     // التحقق من صحة البيانات المدخلة
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

     if (Auth::guard('admin')->attempt($credentials)) {
        // جلب المستخدم المُسجّل دخوله
        $user = Auth::guard('admin')->user();

        // توجيه إلى لوحة تحكم الأدمن
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors(['error' => 'Invalid credentials'])->withInput();
  
    }

    public function Logout(){
    	 Auth::guard('admin')->logout(); 
         session()->flush(); // سيحذف كل بيانات الجلسة
    	return Redirect()->route('admin.login');

    }



    
}
