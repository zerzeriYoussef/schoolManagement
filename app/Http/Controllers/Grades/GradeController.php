<?php 

namespace App\Http\Controllers\Grades;
use App\Http\Controllers\Controller;
use App\Models\Grade; 
use App\Models\Classroom;   
use Illuminate\Http\Request;
use App\Http\Requests\StoreGrades;
use Flasher\Toastr\Prime\ToastrInterface;
use Illuminate\Support\Facades\Session;
use Jubaer\Zoom\Facades\Zoom;

class GradeController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  
  public function index()
  {
    $Grades=Grade::all();
    return view('pages.Grades.Grades',compact('Grades'));
  }
  public function createMeeting(Request $request)
  {
      // Validate request data if necessary
      $request->validate([
          'agenda' => 'required|string|max:255',
          'topic' => 'required|string|max:255',
          'start_time' => 'required|date',
      ]);

      // Create the Zoom meeting
      $meeting = Zoom::createMeeting([
          "agenda" => $request->input('agenda'),
          "topic" => $request->input('topic'),
          "type" => 2, // scheduled meeting
          "duration" => 60, // in minutes
          "timezone" => 'Asia/Dhaka', // or set based on user preference
          "password" => '123456', // optional password
          "start_time" => $request->input('start_time'), // required start time
          "settings" => [
              'join_before_host' => false,
              'host_video' => true,
              'participant_video' => false,
              'mute_upon_entry' => true,
              'waiting_room' => true,
              'audio' => 'both',
              'auto_recording' => 'none',
              'approval_type' => 0, // Automatically Approve
          ],
      ]);

      // Return the created meeting details or redirect as needed
      return response()->json([
          'message' => 'Zoom meeting created successfully!',
          'meeting' => $meeting,
      ]);
  }
  public function listMeetings()
{
    try {
        $meetings = Zoom::user()->meetings(); // Assuming you have the Zoom API setup in Laravel
        return response()->json($meetings);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to retrieve meetings',
            'error' => $e->getMessage(),
        ], 500);
    }
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
  {     if (Grade::where('Name->ar', $request->Name)->orWhere('Name->en',$request->Name_en)->exists()) {

    return redirect()->back()->withErrors(trans('Grades_trans.exists'));
}
    
    $validated = $request->validate([
      'Name' => 'required|string|max:255',
      'Name_en' => 'required|string|max:255',
      'Notes' => 'nullable|string|max:255',
    ],[

      'Name.required' => trans('validation.required'),
      'Name_en.required' => trans('validation.required'),
    


  ]);
  $translations = [
    'en' => $request->Name_en,
    'ar' => $request->Name
];
  Grade::create([
    'name' => ['en' => $request->Name_en, 'ar' => $request->Name],
    'Notes' => $request->Notes,

]);


  // Store the grade using the validated data
  // Your logic here
//hata return view t9dhi
  //toastr()->success(trans('messages.success'));
  //toastr()->success('Your account has been suspended.');
  Session::flash('success', trans('messages.success'));

  return back();    
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
   try{ $validated = $request->validate([
      'Name' => 'required|string|max:255',
      'Name_en' => 'required|string|max:255',
      'Notes' => 'nullable|string|max:255',
    ],[

      'Name.required' => trans('validation.required'),
      'Name_en.required' => trans('validation.required'),
    


  ]);
  $id = $request->id;

  $translations = [
    'en' => $request->Name_en,
    'ar' => $request->Name
];
      Grade::where('id', $id)->update([
        'name' => ['en' => $request->Name_en, 'ar' => $request->Name],
        'Notes' => $request->Notes,
      ]);
  }

        catch (\Exception $e){
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        Session::flash('success', trans('messages.Update'));
        return redirect()->route('Grades.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {
    $MyClass_id = Classroom::where('Grade_id',$request->id)->pluck('Grade_id');
    if($MyClass_id->count() == 0){
    $Grades = Grade::findOrFail($request->id)->delete();
    Session::flash('delete', trans('messages.Delete'));
    return redirect()->route('Grades.index');

  }
  else{

    
    Session::flash('delete', trans('Grades_trans.delete_Grade_Error'));
    return redirect()->route('Grades.index');

}
  
}
}
?>