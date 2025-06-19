<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
class StudentAuthController extends Controller
{
    //
    public function index()
    {
    
        return view('index'); 
    }
    public function showLoginForm()
    {
        return view('auth.student.login');
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

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors(['error' => 'Invalid credentials'])->withInput();
    }
}
