<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Scholarships;
use App\Models\Report;
use App\Models\Paidprograms;
use App\Models\ASupports;
use PDF;
use Auth;

class ReportController extends Controller
{
    //
    public function generateStudentReport(Request $request)
    {
      
        // جلب التاريخ من الطلب
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
   
        // جلب الطلاب الذين سجلوا بين التواريخ
        $students = Student::whereBetween('created_at', [$startDate, $endDate])->get();
      // حساب عدد الطلاب
      $studentCount = $students->count();

  
        return view('admin.report.students', compact('students', 'startDate', 'endDate','studentCount'));
        
    }
    public function generateScholarshipReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $scholarships = Scholarships::whereBetween('created_at', [$startDate, $endDate])->get();
        $scholarshipsCount = $scholarships->count();
      
        return view('admin.report.scholarships', compact('scholarships', 'startDate', 'endDate','scholarshipsCount'));
     
    }
    

    public function generateSupportReport(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
  
    // جلب الـ Supports الذين تم إنشاؤهم بين التواريخ
    $supports = ASupports::whereBetween('created_at', [$startDate, $endDate])->get();
    $supportsCount = $supports ->count();
  
    return view('admin.report.support', compact('supports', 'startDate', 'endDate','supportsCount'));

}


public function generatePaidProgramReport(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // جلب البرامج الدراسية التي تم إنشاؤها بين التواريخ
    $paidprograms = Paidprograms::whereBetween('created_at', [$startDate, $endDate])->get();
    $paidprogramsCount = $paidprograms->count();
    return view('admin.report.paidprograms', compact('paidprograms', 'startDate', 'endDate','paidprogramsCount'));
}


public function downloadPdf(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;
  // جلب ID المسؤول (Admin) الذي قام بإنشاء التقرير
  $adminId = Auth::guard('admin')->id();

  // حفظ التقرير في قاعدة البيانات
  Report::create([
      'report_type' => 'Student', 
      'start_date' => $startDate,
      'end_date' => $endDate,
      'generated_by' => $adminId, // المعرف المسؤول
  ]);
    // جلب البيانات من قاعدة البيانات
    $students = Student::whereBetween('created_at', [$startDate, $endDate])->get();

    // محتوى PDF الديناميكي
    $htmlContent = '<h1>Student Report</h1>';
    $htmlContent .= '<p>Report Date Range: ' . $startDate . ' to ' . $endDate . '</p>';
    $htmlContent .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
    $htmlContent .= '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr></thead>';
    $htmlContent .= '<tbody>';

    foreach ($students as $student) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . $student->id . '</td>';
        $htmlContent .= '<td>' . $student->name . '</td>';
        $htmlContent .= '<td>' . $student->email . '</td>';
        $htmlContent .= '<td>' . $student->created_at . '</td>';
        $htmlContent .= '</tr>';
    }

    $htmlContent .= '</tbody>';
    $htmlContent .= '</table>';

    // إنشاء PDF باستخدام المحتوى
    $pdf = PDF::loadHTML($htmlContent);

    // تحميل الملف
    return $pdf->download('student_report_' . now()->format('Y-m-d') . '.pdf');
}


public function downloadScholarshipPdf(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $adminId = Auth::guard('admin')->id();

    // حفظ التقرير في قاعدة البيانات
    Report::create([
        'report_type' => 'Scholarships', 
        'start_date' => $startDate,
        'end_date' => $endDate,
        'generated_by' => $adminId, // المعرف المسؤول
    ]);
    // جلب البيانات من نموذج Scholarship
    $scholarships = Scholarships::whereBetween('created_at', [$startDate, $endDate])->get();

    // محتوى PDF الديناميكي
    $htmlContent = '<h1>Scholarship Report</h1>';
    $htmlContent .= '<p>Report Date Range: ' . $startDate . ' to ' . $endDate . '</p>';
    $htmlContent .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
    $htmlContent .= '<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Created At</th></tr></thead>';
    $htmlContent .= '<tbody>';

    foreach ($scholarships as $scholarship) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . $scholarship->id . '</td>';
        $htmlContent .= '<td>' . $scholarship->name . '</td>';
        $htmlContent .= '<td>' . $scholarship->description . '</td>';
        $htmlContent .= '<td>' . $scholarship->created_at . '</td>';
        $htmlContent .= '</tr>';
    }

    $htmlContent .= '</tbody>';
    $htmlContent .= '</table>';

    // إنشاء PDF باستخدام المحتوى
    $pdf = PDF::loadHTML($htmlContent);

    // تحميل الملف
    return $pdf->download('scholarship_report_' . now()->format('Y-m-d') . '.pdf');
}

public function downloadPaidProgramPdf(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $adminId = Auth::guard('admin')->id();

    // حفظ التقرير في قاعدة البيانات
    Report::create([
        'report_type' => 'PaidPrograms', 
        'start_date' => $startDate,
        'end_date' => $endDate,
        'generated_by' => $adminId, // المعرف المسؤول
    ]);
    // جلب البيانات من نموذج PaidProgram
    $paidPrograms = PaidPrograms::whereBetween('created_at', [$startDate, $endDate])->get();

    // محتوى PDF الديناميكي
    $htmlContent = '<h1>Paid Program Report</h1>';
    $htmlContent .= '<p>Report Date Range: ' . $startDate . ' to ' . $endDate . '</p>';
    $htmlContent .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
    $htmlContent .= '<thead><tr><th>ID</th><th>Name</th><th>Cost</th><th>Created At</th></tr></thead>';
    $htmlContent .= '<tbody>';

    foreach ($paidPrograms as $program) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . $program->id . '</td>';
        $htmlContent .= '<td>' . $program->name . '</td>';
        $htmlContent .= '<td>' . $program->cost . '</td>';
        $htmlContent .= '<td>' . $program->created_at . '</td>';
        $htmlContent .= '</tr>';
    }

    $htmlContent .= '</tbody>';
    $htmlContent .= '</table>';

    // إنشاء PDF باستخدام المحتوى
    $pdf = PDF::loadHTML($htmlContent);

    // تحميل الملف
    return $pdf->download('paid_program_report_' . now()->format('Y-m-d') . '.pdf');
}


public function downloadSupportPdf(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $adminId = Auth::guard('admin')->id();

    // حفظ التقرير في قاعدة البيانات
    Report::create([
        'report_type' => 'ASupports', 
        'start_date' => $startDate,
        'end_date' => $endDate,
        'generated_by' => $adminId, // المعرف المسؤول
    ]);
    // جلب البيانات من نموذج Support
    $supports = ASupports::whereBetween('created_at', [$startDate, $endDate])->get();

    // محتوى PDF الديناميكي
    $htmlContent = '<h1>Support Report</h1>';
    $htmlContent .= '<p>Report Date Range: ' . $startDate . ' to ' . $endDate . '</p>';
    $htmlContent .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
    $htmlContent .= '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr></thead>';
    $htmlContent .= '<tbody>';

    foreach ($supports as $support) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . $support->id . '</td>';
        $htmlContent .= '<td>' . $support->name . '</td>';
        $htmlContent .= '<td>' . $support->email . '</td>';
        $htmlContent .= '<td>' . $support->created_at . '</td>';
        $htmlContent .= '</tr>';
    }

    $htmlContent .= '</tbody>';
    $htmlContent .= '</table>';

    // إنشاء PDF باستخدام المحتوى
    $pdf = PDF::loadHTML($htmlContent);

    // تحميل الملف
    return $pdf->download('support_report_' . now()->format('Y-m-d') . '.pdf');
}
    


}
