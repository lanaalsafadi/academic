<?php

namespace App\Http\Controllers;

use App\Models\ASupports;
use App\Models\Admin;
use Illuminate\Http\Request;

class ASupportController extends Controller
{
    // عرض جميع الدعم (Support)
    public function index()
    {
        // جلب جميع الدعم مع الإداري المرتبط به
        $supports = ASupports::with('admin')->get();

       
        return view('admin.support.index', compact('supports'));
    }

  
    public function create()
    {
       
        $admins = Admin::all();

        
        return view('admin.support.create', compact('admins'));
    }

    
    public function store(Request $request)
    { 
      
        $request->validate([
           
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:a_supports,email',
            'password' => 'required|string|min:8', 
            'admin_id' => 'required|exists:admins,id',
        ]);
        
       
        ASupports::create([
            
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'admin_id' => $request->admin_id,
        ]);

      
        return redirect()->route('admin.support.index')->with('success', 'Support created successfully.');
    }

 
    public function edit($id)
    {
       
        $support = ASupports::findOrFail($id);

  
        $admins = Admin::all();

       
        return view('admin.support.edit', compact('support', 'admins'));
    }

    // تحديث دعم موجود
    public function update(Request $request, $id)
    {
   
        $request->validate([
           
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:a_supports,email,' . $id,
            'password' => 'nullable|string|min:8', 
            'admin_id' => 'required|exists:admins,id',
        ]);

        
        $support = ASupports::findOrFail($id);

       
        if ($request->filled('password')) {
            $support->password = bcrypt($request->password); 
        }

     
        $support->update([
          
            'name' => $request->name,
            'email' => $request->email,
            'admin_id' => $request->admin_id,
        ]);

      
        return redirect()->route('admin.support.index')->with('success', 'Support updated successfully.');
    }

    // حذف دعم
    public function destroy($id)
    {
     
        $support = ASupports::findOrFail($id);

    
        $support->delete();

        
        return redirect()->route('admin.support.index')->with('success', 'Support deleted successfully.');
    }
}
