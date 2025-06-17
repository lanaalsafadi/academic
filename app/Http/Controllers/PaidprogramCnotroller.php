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
         // جلب البرامج المدفوعةالدراسية مع الجامعة المرتبطة بها
         $paidprograms = Paidprograms::all();

         // عرض البيانات في الـ View
         return view('admin.paidprograms.index', compact('paidprograms'));
     }

     // عرض نموذج إنشاء البرامج المدفوعة دراسية جديدة
     public function create()
     {
         // جلب جميع الجامعات
         $universities = University::all();
 
         // عرض صفحة إضافة البرامج المدفوعة دراسية جديدة مع قائمة الجامعات
         return view('admin.paidprograms.create', compact('universities'));
         
     }
     public function showpaidprograms()
     {
         // جلب جميع المنح الدراسية من قاعدة البيانات
         $paidprograms = Paidprograms::all();
 
         // إرسال البيانات إلى الصفحة
         return view('paidprograms', compact('paidprograms'));
     }
 
     // تخزين االبرامج المدفوعة الدراسية في قاعدة البيانات
     public function store(Request $request)
     {
         // التحقق من البيانات المدخلة
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
         // إنشاء البرامج المدفوعة  دراسية جديدة
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
        

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.paidprograms.index')->with('success', 'paidprograms created successfully.');
    }
     // عرض نموذج تعديل البرنامج المدفوع الدراسية
     public function edit($id)
     {

        $paidprograms = Paidprograms::findOrFail($id);// جلب المنحة الدراسية التي سيتم تعديلها مع الجامعة المرتبطة
         
       
 
         // جلب جميع الجامعات
         $universities = University::all();
      
 
         // عرض صفحة تعديل البرامج المدفوعة  الدراسية
         return view('admin.paidprograms.edit', compact('paidprograms', 'universities'));
     }
     // تحديث البرامج المدفوعة الدراسية
     public function update(Request $request, $id)
     { 
         // التحقق من البيانات المدخلة
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
 
         // جلب البرامج المدفوعة  الدراسية التي سيتم تعديلها
         $paidprograms = Paidprograms::findOrFail($id);
         
         // تحديث البيانات
             
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
 
         // إعادة التوجيه مع رسالة نجاح
         return redirect()->route('admin.paidprograms.index')->with('success', 'paidprograms updated successfully.');
     }
          // حذف المنحة الدراسية
          public function destroy($id)
          {   
              // جلب المنحة الدراسية التي سيتم حذفها
              $paidprograms = Paidprograms::findOrFail( $id);
      
              // حذف المنحة الدراسية
              $paidprograms->delete();
      
              // إعادة التوجيه مع رسالة نجاح
              return redirect()->route('admin.paidprograms.index')->with('success', 'paidprograms deleted successfully.');
          }


          public function search(Request $request)
     {
         $query = Paidprograms::query();
     
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
           // فحص إذا كان المستخدم قد اختار type والبحث عنها
           if ($request->filled('type')) {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }
     
        
     
         // جلب الدول بدون تكرار
         $countries = Paidprograms::distinct()->get(['country']);
         
         // جلب الجامعات بدون تكرار
         $universities = University::distinct()->get(['name']);
      $type=Paidprograms::distinct()->get(['type']);
         // جلب البيانات مع العلاقة
         $paidprograms = $query->with('university')->get();
     
         
     
         return view('paidprograms', compact('paidprograms', 'universities', 'countries','type'));
     }
}
