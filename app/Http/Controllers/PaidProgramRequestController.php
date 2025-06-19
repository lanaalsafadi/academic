<?php

namespace App\Http\Controllers;

use App\Models\RequestPaidProgram;
use App\Models\Student;
use App\Models\Paidprograms;
use Illuminate\Http\Request;

class PaidProgramRequestController extends Controller
{
    //

        // دالة لحفظ طلب البرنامج المدفوع
        public function storePaidProgramRequest(Request $request)
        {$validated = $request->validate([
            'type' => 'in:master,university,phd',
            
        ]);
            
            $student = Student::find($request->student_id);
            $paidProgram = Paidprograms::find($request->paid_program_id);
    
            
            if ($student && $paidProgram) {
                 
        $existingRequest = RequestPaidProgram::where('student_id', $student->id)
        ->where('paid_program_id', $paidProgram->id)
        ->first();


if ($existingRequest) {
return redirect()->back()->with('error', 'لقد تقدمت مسبقًا لهذا البرنامج المدفوع.');
}
              
                RequestPaidProgram::create([
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'paid_program_id' => $paidProgram->id,
                    'paid_program_name' => $paidProgram->name,
                    'application_date' => now(),
                ]);
    
                
        return redirect($paidProgram->application_url)->with('success', 'تم التقديم للمنحة بنجاح!');
            }
    
           
            return redirect()->back()->with('error', 'خطأ في التقديم. تأكد من وجود الطالب والبرنامج المدفوع.');
        }
    
}
