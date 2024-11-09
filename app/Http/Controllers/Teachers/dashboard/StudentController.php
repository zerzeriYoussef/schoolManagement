<?php
namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Matier;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{

    public function index()
    {
        $teacher = Auth::guard('teacher')->user();  // Use the explicit guard
        $matiers=Matier::all();
        $ids= DB::table('teacher_section')->where('teacher_id', $teacher->id)->pluck('section_id');
        $students = Student::whereIn('section_id',$ids)->get();
        return view('pages.Teachers.students.index',compact('students','matiers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sections()
    {
        $teacher = Auth::guard('teacher')->user();  // Use the explicit guard

        $ids = DB::table('teacher_section')->where('teacher_id', $teacher->id)->pluck('section_id');
        $sections = Section::whereIn('id', $ids)->get();
        return view('pages.Teachers.sections.index', compact('sections'));
    }
    public function attendance(Request $request)
    {
        try {
            $attenddate = date('Y-m-d');
    
            if (is_array($request->attendences)) {
                foreach ($request->attendences as $studentId => $attendanceData) {
                    if (isset($attendanceData['status'], $attendanceData['matier_id'])) {
                        $attendence_status = $attendanceData['status'] === 'presence';
    
                        Attendance::create([
                            'student_id' => $studentId,
                            'grade_id' => $request->grade_id,
                            'classroom_id' => $request->classroom_id,
                            'section_id' => $request->section_id,
                            'teacher_id' => $request->teacher_id,
                            'attendence_date' => $attenddate,
                            'attendence_status' => $attendence_status,
                            'matier_id' => $request->matie,
                        ]);
                    }
                }
            }
    
            Session::flash('success', trans('messages.success'));
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    


    


    public function editAttendance(Request $request)
    {
        try {
            $date = date('Y-m-d');  // Current date for attendance record
            // Find the attendance record by date, student_id, and matier_id
            $attendanceRecord = Attendance::where('attendence_date', $date)
                ->where('student_id', $request->id)
                ->where('matier_id', $request->mati)
                ->first();
            dd($attendanceRecord);
            // Check if attendance record exists
            if ($attendanceRecord) {
                // Determine the attendance status based on the submitted value
                $attendanceStatus = $request->attendences === 'presence';
    
                // Update the attendance status
                $attendanceRecord->update([
                    'attendence_status' => $attendanceStatus
                ]);
    
                Session::flash('success', trans('messages.success'));
            } else {
                Session::flash('error', trans('messages.no_attendance_record'));
            }
    
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    public function attendanceReport(){
        $teacher = Auth::guard('teacher')->user();
        $ids = DB::table('teacher_section')->where('teacher_id',    $teacher->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        return view('pages.Teachers.students.attendance_report', compact('students'));
    
    }
    
    public function attendanceSearch(Request $request){


        $request->validate([
            'from'  =>'required|date|date_format:Y-m-d',
            'to'=> 'required|date|date_format:Y-m-d|after_or_equal:from'
        ],[
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);
    
        $teacher = Auth::guard('teacher')->user();
    
        $ids = DB::table('teacher_section')->where('teacher_id',$teacher->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
    
    if($request->student_id == 0){
    
       $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
       return view('pages.Teachers.students.attendance_report',compact('Students','students'));
    }
    
    else{
    
       $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
       ->where('student_id',$request->student_id)->get();
       return view('pages.Teachers.students.attendance_report',compact('Students','students'));
    
    
    }
    
    
    
    }
    
    }
    
