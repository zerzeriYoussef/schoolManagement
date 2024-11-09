<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller{

    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        $information = Teacher::findorFail($teacher->id);
        return view('pages.Teachers.profile', compact('information'));

    }

    public function update(Request $request, $id)
    {

        $information = Teacher::findorFail($id);

        if (!empty($request->password)) {
            $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }
        Session::flash('success', trans('messages.Update'));
        return redirect()->back();


    }



}