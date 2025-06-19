<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

use Illuminate\Support\Facades\Auth;
class StudentController extends Controller
{   public function index()
    {
        
        $students = Student::all(); 
    
       
        return view('admin.student.index', compact('students'));
    }
    public function view()
    { 
        return redirect()->back()->with('success', 'Registration successful. Please login.');

    }
    public function Block()
    {
        
        $students = Student::all(); 
    
       
        return view('admin.student.block', compact('students'));
    }
    public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'password' => 'required|string|min:8',
            'age' => 'required|integer|min:18',  
            'phone' => 'required|string',
            'gender' => 'required|string',
        ]);
        

       
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = bcrypt($request->password); 
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->save();


        
        return redirect()->back()->with('success', 'Registration successful. Please login.');
    }
    
      public function destroy($id)
      {
          $student = Student::findOrFail($id);
          $student->delete();
  
          return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
      }
      
      public function login(Request $request)
      {    
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required|string', 
        ]);
        
          $credentials = $request->only('email', 'password');
         
          if (Auth::guard('student')->attempt($credentials)) {
            
              return redirect()->route('student.dashboard');
          }
   
          return back()->withErrors(['email' => 'Invalid credentials']);
      }
      public function Logout(Request $request){
    	Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
       
        return redirect('/')->with('success', 'Logout successful. Please login.');
    }

}

