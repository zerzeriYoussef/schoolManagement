<?php


namespace App\Repository;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\promotion;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StudentGraduatedRepository implements StudentGraduatedRepositoryInterface
{

    public function index()
    {
        $students = Student::onlyTrashed()->get();
        return view('pages.Students.Graduated.index',compact('students'));
    }

    public function create()
    {
        $Grades = Grade::all();
        $class=Section::all();
        return view('pages.Students.Graduated.create',compact('Grades','class'));
    }

    public function SoftDelete($request)
    {

        

            $students = student::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();

            if($students->count() < 1){
                Session::flash('delete', trans(' لا توجد بيانات في جدول الطلاب '));

                return redirect()->back();
            }

            // update in table student
            $Students=$request->students_list;
            foreach ($students as $student){
                foreach($Students as $y){
                    if($y==$student->id){
                        student::where('id',$student->id)->Delete();
                    }
                }
               // $ids = explode(',',$student->id);
               

                // insert in to promotions
             

            }
            Session::flash('success', trans('messages.success'));
            return redirect()->route('Graduated.index');


       

    }

    public function destroy($request)
    {
    
    }
    


}
