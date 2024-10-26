<?php

namespace App\Http\Controllers\Sections;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use App\Models\section;

use App\Models\Classroom;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Matier;
use App\Models\Teacher;

class MatierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matiers = Matier::all();
        $sections= section::all();
        return view('pages.Matier.Matier',compact('matiers','sections'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function store(Request $request)
    {     
      
      $validated = $request->validate([
        'Name' => 'required|string|max:255',
        'Name_en' => 'required|string|max:255',
      ],[
  
        'Name.required' => trans('validation.required'),
        'Name_en.required' => trans('validation.required'),
      
  
  
    ]);
    $translations = [
      'en' => $request->Name_en,
      'ar' => $request->Name
  ];
  $matier = new Matier();
  $matier->setTranslation('name', 'en', $request->Name_en);
  $matier->setTranslation('name', 'ar', $request->Name);
  $matier->section_id = 4;
 
  $matier->save();
  $matier->sectionse()->attach($request->section_id);

  
  
    // Store the grade using the validated data
    // Your logic here
  //hata return view t9dhi
    //toastr()->success(trans('messages.success'));
    //toastr()->success('Your account has been suspended.');
    Session::flash('success', trans('messages.success'));
  
    return back();    
    }
    /**
     * Store a newly created resource in storage.
     */
 

    /**
     * Remove the specified resource from storage.
     */
 


    
    
}
