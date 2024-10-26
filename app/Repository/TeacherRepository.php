<?php

namespace App\Repository;
use App\Models\Teacher;
use App\Models\Gender;
use App\Models\Specialization;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

class TeacherRepository implements TeacherRepositoryInterface{

  public function getAllTeachers(){
      return Teacher::all();
  }
  public function Getspecialization(){
    return specialization::all();
}

public function GetGender(){
   return Gender::all();
}
    public function StoreTeachers($request){

          $Teachers = new Teacher();
          $Teachers->Email = $request->Email;
          $Teachers->Password =  Hash::make($request->Password);
         // $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
          $Teachers->setTranslation('Name', 'en', $request->Name_en);
          $Teachers->setTranslation('Name', 'ar', $request->Name_ar);

          $Teachers->Specialization_id = $request->Specialization_id;
          $Teachers->Gender_id = $request->Gender_id;
          $Teachers->Joining_Date = $request->Joining_Date;
          $Teachers->Address = $request->Address;
          $Teachers->save();
          Session::flash('success', trans('messages.success'));
          return redirect()->route('Teachers.index');
     

  }
  public function editTeachers($id)
  {
      return Teacher::findOrFail($id);
  }
  public function UpdateTeachers($request)
    {
        
            $Teachers = Teacher::findOrFail($request->id);
            $Teachers->Email = $request->Email;
            $Teachers->Password =  Hash::make($request->Password);
           // $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->setTranslation('Name', 'en', $request->Name_en);
            $Teachers->setTranslation('Name', 'ar', $request->Name_ar);
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            Session::flash('success', trans('messages.success'));
            return redirect()->route('Teachers.index');
          
       
    }
    public function deleteTeacher($request){
      
    Teacher::findOrFail($request->id)->delete();
    Session::flash('delete', trans('messages.delete'));
    return redirect()->route('Teachers.index');
  }
}