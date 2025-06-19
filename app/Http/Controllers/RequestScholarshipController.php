<?php

namespace App\Http\Controllers;
use App\Models\RequestScholarship;
use App\Models\Student;
use App\Models\Scholarships;

use Illuminate\Http\Request;

class RequestScholarshipController extends Controller
{
    //

    public function storeScholarshipRequest(Request $request)
    { 
        $validated = $request->validate([
            'type' => 'in:master,university,phd',
            'funding_type' => 'in:Full,Partial',
        ]);
        
        $student = Student::find($request->student_id);
        $scholarship = Scholarships::find($request->scholarship_id);
 

        if ($student && $scholarship) {
          
           $existingRequest = RequestScholarship::where('student_id', $student->id)
           ->where('scholarship_id', $scholarship->scholarships_ID)
           ->first();


if ($existingRequest) {
 
return redirect()->back()->with('error', 'لقد تقدمت مسبقًا لهذه المنحة.');
}
           
            RequestScholarship::create([
                'student_id' => $student->id,
                'student_name' => $student->name,
                'scholarship_id' => $scholarship->scholarships_ID,
                'scholarship_name' => $scholarship->name,
                'type' => $request->type,  
                'funding_type' => $request->funding_type,  
                'application_date' => now(),
               
              
            ]);
           
        return redirect($scholarship->application_url)->with('success', 'تم التقديم للمنحة بنجاح!');
        }

        return redirect()->back()->with('error', 'خطأ في التقديم. تأكد من وجود الطالب والمنحة.');
    }
}
