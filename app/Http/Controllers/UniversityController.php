<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;

class UniversityController extends Controller
{
   
    public function index()
    {
        $universities = University::all(); 
        return view('admin.universities.index', compact('universities'));
    }

   
    public function create()
    {
       
        return view('admin.universities.create'); 
    }

    public function store(Request $request)
 {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'established_year' => 'required|integer|between:1096,' . now()->year,
            'website' => 'nullable|url',
        ]);

       
        University::create($request->all());

        return redirect()->route('admin.universities.index')->with('success', 'University created successfully.');
    }

   
    public function show($id)
    {
        $university = University::findOrFail($id); 
        return view('admin.universities.show', compact('university'));
    }

  
    public function edit($id)
    {
        $university = University::findOrFail($id); 
        return view('admin.universities.edit', compact('university'));
    }

    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'established_year' => 'required|integer|between:1096,' . now()->year,
            'website' => 'nullable|url',
        ]);

        $university = University::findOrFail($id); 
        $university->update($request->all()); 

        return redirect()->route('admin.universities.index')->with('success', 'University updated successfully.');
    }

   
    public function destroy($id)
    {
        $university = University::findOrFail($id); 
        $university->delete(); 

        return redirect()->route('admin.universities.index')->with('success', 'University deleted successfully.');
    }
        
}
