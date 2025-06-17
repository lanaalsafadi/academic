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
         // جلب المنح الدراسية مع الجامعة المرتبطة بها
         $scholarships = Scholarships::all();

         // عرض البيانات في الـ View
         return view('admin.scholarships.index', compact('scholarships'));
     }
     public function showscholarships()
     {
         // جلب جميع المنح الدراسية من قاعدة البيانات
         $scholarships = Scholarships::all();
 
         // إرسال البيانات إلى الصفحة
         return view('scholarships', compact('scholarships'));
     }
 
     // عرض نموذج إنشاء منحة دراسية جديدة
     public function create()
     {
         // جلب جميع الجامعات
         $universities = University::all();
 
         // عرض صفحة إضافة منحة دراسية جديدة مع قائمة الجامعات
         return view('admin.scholarships.create', compact('universities'));
     }
 
     // تخزين المنحة الدراسية في قاعدة البيانات
     public function store(Request $request)
     {
         // التحقق من البيانات المدخلة
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
 
         // إنشاء منحة دراسية جديدة
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
 
         // إعادة التوجيه مع رسالة نجاح
         return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship created successfully.');
     }
 
     // عرض نموذج تعديل المنحة الدراسية
     public function edit($id)
     {
        $scholarship = Scholarships::where('scholarships_ID', $id)->firstOrFail();// جلب المنحة الدراسية التي سيتم تعديلها مع الجامعة المرتبطة
         
       
 
         // جلب جميع الجامعات
         $universities = University::all();
      
 
         // عرض صفحة تعديل المنحة الدراسية
         return view('admin.scholarships.edit', compact('scholarship', 'universities'));
     }
 
     // تحديث المنحة الدراسية
     public function update(Request $request, $id)
     { 
         // التحقق من البيانات المدخلة
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
 
         // جلب المنحة الدراسية التي سيتم تعديلها
         $scholarship = Scholarships::where('scholarships_ID', $id)->firstOrFail();
         
         // تحديث البيانات
             
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
 
         // إعادة التوجيه مع رسالة نجاح
         return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship updated successfully.');
     }
 
     // حذف المنحة الدراسية
     public function destroy($id)
     {   
         // جلب المنحة الدراسية التي سيتم حذفها
         $scholarship = Scholarships::where('scholarships_ID', $id)->firstOrFail();
 
         // حذف المنحة الدراسية
         $scholarship->delete();
 
         // إعادة التوجيه مع رسالة نجاح
         return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship deleted successfully.');
     }

     public function search(Request $request)
     {
         $query = Scholarships::query();
     
         // فحص إذا كان المستخدم قد اختار جامعة والبحث عنها
         if ($request->filled('university')) {
             $query->whereHas('university', function($query) use ($request) {
                 $query->where('name', 'LIKE', '%' . $request->university . '%');
             });
         }
     
         // فحص إذا كان المستخدم قد اختار دولة والبحث عنها
         if ($request->filled('place')) {
             $query->where('country', 'LIKE', '%' . $request->place . '%');
         }
     
         // فحص إذا كان المستخدم قد اختار نوع تمويل والبحث عنه
         if ($request->filled('fundingType')) {
             $query->where('funding_type', 'LIKE', '%' . $request->fundingType . '%');
         }
          // فحص إذا كان المستخدم قد اختار type
          if ($request->filled('type')) {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }
     
         // جلب الدول بدون تكرار
         $countries = Scholarships::distinct()->get(['country']);
         
         // جلب الجامعات بدون تكرار
         $universities = University::distinct()->get(['name']);
     
         // جلب البيانات مع العلاقة
         $scholarships = $query->with('university')->get();
     
         $type=Scholarships::distinct()->get(['type']);
     
         return view('scholarships', compact('scholarships', 'universities', 'countries','type'));
     }
    }
