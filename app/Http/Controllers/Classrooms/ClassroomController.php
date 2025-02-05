<?php 
namespace App\Http\Controllers\Classrooms;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Classroom;   
use App\Models\Grade;   
use Flasher\Toastr\Prime\ToastrInterface;
use Illuminate\Support\Facades\Session;
class ClassroomController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $Grades = Grade::all();
      $My_Classes = Classroom::all();
  
    /*  foreach ($My_Classes as $classroom) {
          if (is_string($classroom->Name_Class)) {
              $classroom->Name_Class = json_decode($classroom->Name_Class, true);
          }
      }*/
  
      return view('pages.My_Classes.My_Classes', compact('My_Classes', 'Grades'));
  }
  

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $List_Classes = $request->List_Classes;
  
      // Validate the input data
      $request->validate([
          'List_Classes.*.Name_class_en' => 'required',
          'List_Classes.*.Name' => 'required',
      ],[
          'List_Classes.*.Name.required' => trans('validation.required'),
          'List_Classes.*.Name_class_en.required' => trans('validation.required'),
      ]);
      
      try {
          foreach ($List_Classes as $List_Class) {
              // Use the Spatie\Translatable\HasTranslations package to handle translations
              $classroom = new Classroom();
$classroom->setTranslation('Name_Class', 'en', $List_Class['Name_class_en']);
$classroom->setTranslation('Name_Class', 'ar', $List_Class['Name']);
$classroom->Grade_id = $List_Class['Grade_id'];
$classroom->save();

          }
         
  
          // Flash success message and redirect
          Session::flash('success', trans('messages.success'));
          return redirect()->route('Classrooms.index');
  
      } catch (\Exception $e) {
          // Handle any exceptions
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }
  }
  

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request)
  {
    $id=$request->id;
    $translations = [
      'en' => $request->Name_en,
      'ar' => $request->Name
  ];
   /* Classroom::where('id', $id)->update([
      'Name_Class' => ['en' => $request->Name_en, 'ar' => $request->Name],
      'Grade_id'=>$request->Grade_id,
    ]);
    Session::flash('success', trans('messages.Update'));
        return redirect()->route('Classrooms.index');*/
        try {
            // Find the existing classroom by ID
            $classroom = Classroom::findOrFail($id);
    
            // Use the Spatie\Translatable\HasTranslations package to handle translations
            $classroom->setTranslation('Name_Class', 'en', $request->Name_en);
            $classroom->setTranslation('Name_Class', 'ar', $request->Name);
            $classroom->Grade_id = $request->Grade_id;
    
            // Save the updated classroom
            $classroom->save();
    
            // Flash success message and redirect
            Session::flash('success', trans('messages.success'));
            return redirect()->route('Classrooms.index');
        
        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {
    $Grades = Classroom::findOrFail($request->id)->delete();
    Session::flash('delete', trans('messages.Delete'));
    return redirect()->route('Classrooms.index');
  }
  public function delete_all(Request $request)
  {
      $delete_all_id = explode(",", $request->delete_all_id);// rodo array w ofsel binhom

      Classroom::whereIn('id', $delete_all_id)->Delete();// ta5o array barcha hajat
      Session::flash('delete', trans('messages.Delete'));
      return redirect()->route('Classrooms.index');
  }
  
}

?>