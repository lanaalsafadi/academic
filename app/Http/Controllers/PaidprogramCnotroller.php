<?php

namespace App\Http\Controllers;
use App\Models\University;
use App\Models\Paidprograms;
use Illuminate\Http\Request;

class PaidprogramCnotroller extends Controller
{
    //
    //
     // عرض جميع البرامج المدفوعة الدراسية مع الجامعة المرتبطة
     public function index()
     {
        
         $paidprograms = Paidprograms::all();

       
         return view('admin.paidprograms.index', compact('paidprograms'));
     }

     // عرض نموذج إنشاء البرامج المدفوعة دراسية جديدة
     public function create()
     {
         
         $universities = University::all();
 
         
         return view('admin.paidprograms.create', compact('universities'));
         
     }
     public function showpaidprograms()
     {
       
         $paidprograms = Paidprograms::all();
 
        
         return view('paidprograms', compact('paidprograms'));
     }
 
     // تخزين االبرامج المدفوعة الدراسية في قاعدة البيانات
     public function store(Request $request)
     {
        
         $request->validate([
             'university_ID' => 'required|exists:universities,id',
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
             'start_date' => 'required|date',
             'end_date' => 'required|date',
             'cost' => 'required|numeric',
             'type' => 'required|in:master,university,phd',
             'country' => 'required|string|max:255',
             'uploaded_data' => 'nullable|json',
              'application_url' => 'nullable|url'
             
         ]);
         
         Paidprograms::create([
            'university_ID' => $request->university_ID,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'cost' => $request->cost,
            'type' => $request->type,
            'country' => $request->country,
            'uploaded_data' => $request->uploaded_data,
            'application_url' => $request->application_url,
        ]);
        

 
        return redirect()->route('admin.paidprograms.index')->with('success', 'paidprograms created successfully.');
    }
     // عرض نموذج تعديل البرنامج المدفوع الدراسية
     public function edit($id)
     {

        $paidprograms = Paidprograms::findOrFail($id);
         
         $universities = University::all();
         return view('admin.paidprograms.edit', compact('paidprograms', 'universities'));
     }
     // تحديث البرامج المدفوعة الدراسية
     public function update(Request $request, $id)
     { 
         
         $request->validate([
             'university_ID' => 'required|exists:universities,id',
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
             'start_date' => 'required|date',
             'end_date' => 'required|date',
             'cost' => 'required|numeric',
             'type' => 'required|in:master,university,phd',
             'country' => 'required|string|max:255',
             'uploaded_data' => 'nullable|json',
             'application_url' => 'nullable|url'
         ]); 
 
         
         $paidprograms = Paidprograms::findOrFail($id);
         
      
             
         $paidprograms->update([ 
             'university_ID' => $request->university_ID,
             'name' => $request->name,
             'description' => $request->description,
             'start_date' => $request->start_date,
             'end_date' => $request->end_date,
             'cost' => $request->cost,
             'type' => $request->type,
             'country' => $request->country,
             'uploaded_data' => $request->uploaded_data,
             'application_url' => $request->application_url,
         ]);
 
      
         return redirect()->route('admin.paidprograms.index')->with('success', 'paidprograms updated successfully.');
     }
          // حذف المنحة الدراسية
          public function destroy($id)
          {   
              $paidprograms = Paidprograms::findOrFail( $id);
      
              $paidprograms->delete();
      
              return redirect()->route('admin.paidprograms.index')->with('success', 'paidprograms deleted successfully.');
          }


          public function search(Request $request)
     {
         $query = Paidprograms::query();
     
      
         if ($request->filled('university')) {
             $query->whereHas('university', function($query) use ($request) {
                 $query->where('name', 'LIKE', '%' . $request->university . '%');
             });
         }
     
  
         if ($request->filled('place')) {
             $query->where('country', 'LIKE', '%' . $request->place . '%');
         }
   
           if ($request->filled('type')) {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }
     
        
     
   
         $countries = Paidprograms::distinct()->get(['country']);
        
         $universities = University::distinct()->get(['name']);
      $type=Paidprograms::distinct()->get(['type']);
         $paidprograms = $query->with('university')->get();
     
         
     
         return view('paidprograms', compact('paidprograms', 'universities', 'countries','type'));
     }
}
