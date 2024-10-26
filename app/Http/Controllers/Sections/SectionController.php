<?php

namespace App\Http\Controllers\Sections;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use App\Models\section;

use App\Models\Classroom;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Teacher;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grades = Grade::with(['Sections'])->get();
        $sections= section::all();
        $list_Grades = Grade::all();
        $teachers= Teacher::all();
    
        return view('pages.Sections.Sections',compact('Grades','list_Grades','sections','teachers'));    }
  

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'Name_Section_Ar' => 'required',
                'Name_Section_En' => 'required',
            ],[
                'Name_Section_Ar.required' => trans('validation.required'),
                'Name_Section_En.required' => trans('validation.required'),
            ]);

            /*Section::create([
                'Name_Section' => [
                    'en' => $request->Name_Section_En,
                    'ar' => $request->Name_Section_Ar
                ],
                'Status' => 1,
                'Class_id' => $request->Class_id,
                'Grade_id' => $request->Grade_id,
            ]);*/
            $Section = new Section();
            $Section->setTranslation('Name_Section', 'en', $request->Name_Section_En);
            $Section->setTranslation('Name_Section', 'ar', $request->Name_Section_Ar);
            $Section->Grade_id = $request->Grade_id;
            $Section->Class_id = $request->Class_id;
            $Section->Status = 1;
            $Section->save();
            $Section->teachers()->attach($request->teacher_id);

            Session::flash('success', trans('messages.success'));
            return redirect()->route('Sections.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'Name_Section_Ar' => 'required',
                'Name_Section_En' => 'required',
            ],[
                'Name_Section_Ar.required' => trans('validation.required'),
                'Name_Section_En.required' => trans('validation.required'),
            ]);
            $Sections = Section::findOrFail($request->id);
            $Sections->setTranslation('Name_Section', 'en', $request->Name_Section_En);
            $Sections->setTranslation('Name_Section', 'ar', $request->Name_Section_Ar);
            $Sections->Grade_id = $request->Grade_id;
            $Sections->Class_id = $request->Class_id;

    
            // Save the updated classroom
           // $classroom->save();
           /* $Sections->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $Sections->Grade_id = $request->Grade_id;
            $Sections->Class_id = $request->Class_id;
      */
            if(isset($request->Status)) {
              $Sections->Status = 1;
            } else {
              $Sections->Status = 2;
            }
      
            $Sections->save();
            Session::flash('success', trans('messages.success'));
            return redirect()->route('Sections.index');
        }
        catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
  {

    Section::findOrFail($request->id)->delete();
    Session::flash('delete', trans('messages.success'));
    return redirect()->route('Sections.index');

  }
    public function getClasses($grade_id)
{
    $classes = Classroom::where('Grade_id', $grade_id)->pluck('Name_Class', 'id');
    return response()->json($classes);
}


    
    
}
