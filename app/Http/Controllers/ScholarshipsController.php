<?php

namespace App\Http\Controllers;
use App\Models\Scholarships;
use App\Models\University;
use Illuminate\Http\Request;

class ScholarshipsController extends Controller
{
    //
     // عرض جميع المنح الدراسية مع الجامعة المرتبطة
     public function index()
     {
      
         $scholarships = Scholarships::all();

         
         return view('admin.scholarships.index', compact('scholarships'));
     }
     public function showscholarships()
     {
         
         $scholarships = Scholarships::all();
 
         
         return view('scholarships', compact('scholarships'));
     }
 
     // عرض نموذج إنشاء منحة دراسية جديدة
     public function create()
     {
        
         $universities = University::all();
 
         
         return view('admin.scholarships.create', compact('universities'));
     }
 
     // تخزين المنحة الدراسية في قاعدة البيانات
     public function store(Request $request)
     {
         
         $request->validate([
             'university_ID' => 'required|exists:universities,id',
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
             'start_date' => 'required|date',
             'end_date' => 'required|date',
             'cost' => 'nullable|numeric',
             'type' => 'required|in:master,university,phd',
             'funding_type' => 'required|in:Full,Partial',
             'funding_amount' => 'nullable|numeric',
             'eligibility_criteria' => 'nullable|string',
             'country' => 'required|string|max:255',
             'uploaded_data' => 'nullable|json',
             'application_url' => 'nullable|url'
         ]);
 
       
         Scholarships::create([
             'university_ID' => $request->university_ID,
             'name' => $request->name,
             'description' => $request->description,
             'start_date' => $request->start_date,
             'end_date' => $request->end_date,
             'cost' => $request->cost,
             'type' => $request->type,
             'funding_type' => $request->funding_type,
             'funding_amount' => $request->funding_amount,
             'eligibility_criteria' => $request->eligibility_criteria,
             'country' => $request->country,
             'uploaded_data' => $request->uploaded_data,
             'application_url' => $request->application_url,
         ]);
 
       
         return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship created successfully.');
     }
 
 
     public function edit($id)
     {
        $scholarship = Scholarships::where('scholarships_ID', $id)->firstOrFail();
      
         $universities = University::all();
      
 
        
         return view('admin.scholarships.edit', compact('scholarship', 'universities'));
     }
 
     // تحديث المنحة الدراسية
     public function update(Request $request, $id)
     { 
         
         $request->validate([
             'university_ID' => 'required|exists:universities,id',
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
             'start_date' => 'required|date',
             'end_date' => 'required|date',
             'cost' => 'nullable|numeric',
             'type' => 'required|in:master,university,phd',
             'funding_type' => 'required|in:Full,Partial',
             'funding_amount' => 'nullable|numeric',
             'eligibility_criteria' => 'nullable|string',
             'country' => 'required|string|max:255',
             'uploaded_data' => 'nullable|json',
             'application_url' => 'nullable|url'
         ]); 
 
       
         $scholarship = Scholarships::where('scholarships_ID', $id)->firstOrFail();
         
        
             
         $scholarship->update([ 
             'university_ID' => $request->university_ID,
             'name' => $request->name,
             'description' => $request->description,
             'start_date' => $request->start_date,
             'end_date' => $request->end_date,
             'cost' => $request->cost,
             'type' => $request->type,
             'funding_type' => $request->funding_type,
             'funding_amount' => $request->funding_amount,
             'eligibility_criteria' => $request->eligibility_criteria,
             'country' => $request->country,
             'uploaded_data' => $request->uploaded_data,
             'application_url' => $request->application_url,
         ]);
 
         
         return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship updated successfully.');
     }
 
     // حذف المنحة الدراسية
     public function destroy($id)
     {   
         
         $scholarship = Scholarships::where('scholarships_ID', $id)->firstOrFail();
 
         
         $scholarship->delete();
 
         
         return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship deleted successfully.');
     }

     public function search(Request $request)
     {
         $query = Scholarships::query();
     
         
         if ($request->filled('university')) {
             $query->whereHas('university', function($query) use ($request) {
                 $query->where('name', 'LIKE', '%' . $request->university . '%');
             });
         }
     
        
         if ($request->filled('place')) {
             $query->where('country', 'LIKE', '%' . $request->place . '%');
         }
     
   
         if ($request->filled('fundingType')) {
             $query->where('funding_type', 'LIKE', '%' . $request->fundingType . '%');
         }
          
          if ($request->filled('type')) {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }
     
     
         $countries = Scholarships::distinct()->get(['country']);
         
    
         $universities = University::distinct()->get(['name']);
     
      
         $scholarships = $query->with('university')->get();
     
         $type=Scholarships::distinct()->get(['type']);
     
         return view('scholarships', compact('scholarships', 'universities', 'countries','type'));
     }
    }
