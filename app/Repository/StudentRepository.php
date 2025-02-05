<?php

namespace App\Repository;

use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\My_Parent;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

use App\Models\Specialization;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

class StudentRepository implements StudentRepositoryInterface{
    public function Get_Student(){
        $students = Student::paginate(3);
        return view('pages.Students.index',compact('students'));
        
    }
    public function Store_Student($request){

      
        DB::beginTransaction();

            $students = new Student();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
       
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            // insert img
            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$request->name_en, $file->getClientOriginalName(), 'upload_attachments');

                    // insert in image_table
                    $images= new Image();
                    $images->filename=$name;
                    $images->imageable_id= $students->id;
                    $images->imageable_type = Student::class;
                    $images->save();
                }
            }
            DB::commit(); // insert data
            Session::flash('success', trans('messages.success'));
            return redirect()->route('Students.create');
        }        

    public function Create_Student(){
       
        $data['my_classes'] = Grade::all();
        $data['parents'] = My_Parent::all();
        $data['classrooms'] = Classroom::all();
        $data['sections'] = Section::all();
        $data['Genders'] = Gender::all();
        return view('pages.Students.add',$data);
 
     }
     public function Edit_Student($id)
     {
         $data['Grades'] = Grade::all();
         $data['parents'] = My_Parent::all();
         $data['Genders'] = Gender::all();
         $Students =  Student::findOrFail($id);
         return view('pages.Students.edit',$data,compact('Students'));
     }
     
     public function Get_classrooms($id){

        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
        return $list_classes;

    }
    public function Get_Sections($id){

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return response()->json($list_sections);  // Ensure this returns JSON

    }
    public function Delete_Student($request)
    {

        Student::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');
    }
    public function Update_Student($request)
    {
        try {
            $Edit_Students = Student::findorfail($request->id);
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->email = $request->email;
            $Edit_Students->password = Hash::make($request->password);
            $Edit_Students->gender_id = $request->gender_id;
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->Classroom_id = $request->Classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();
            Session::flash('success', trans('messages.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function Show_Student($id){
        $Student = Student::findorfail($id);
        return view('pages.Students.show',compact('Student'));
        
    }
    public function Upload_attachment($request){
        foreach($request->file('photos') as $file)
        {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

            // insert in image_table
            $images= new image();
            $images->filename=$name;
            $images->imageable_id = $request->student_id;
            $images->imageable_type = 'App\Models\Student';
            $images->save();
            Session::flash('success', trans('messages.success'));
            return redirect()->route('Students.show',$request->student_id);
        }
    }
    public function Download_attachment($studentsname,$filename){
//vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleCookieRedirect.php
//8adi sal7t prblm download
        $filePath = public_path('attachments/students/'.$studentsname.'/'.$filename);

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return abort(404, 'File not found.');
        }
    }
    public function Delete_attachment($request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);

        // Delete in data
        image::where('id',$request->id)->where('filename',$request->filename)->delete();
        Session::flash('delete', trans('messages.delete'));
    return redirect()->route('Students.show',$request->student_id);
    }






}