<?php 
namespace App\Http\Controllers\Classrooms;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Classroom;   
use App\Models\Grade;   
use Flasher\Toastr\Prime\ToastrInterface;
use Illuminate\Support\Facades\Http;
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
    $url = 'http://localhost:8001/wordpress/wp-json/service-api/v1/requests';

    // Make a GET request to the WordPress API
    $response = Http::get($url);

    // Check if the request was successful
    if ($response->successful()) {
        // Decode the JSON response
        $data = $response->json();

        // Process the data (e.g., save to database, return as JSON, etc.)
       
    } else {
        // Handle the error
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch data from WordPress API',
            'error' => $response->status(),
        ], $response->status());
    }

    /*  $Grades = Grade::all();
      $My_Classes = Classroom::all();
  
    /*  foreach ($My_Classes as $classroom) {
          if (is_string($classroom->Name_Class)) {
              $classroom->Name_Class = json_decode($classroom->Name_Class, true);
          }
      }*/
  
      return view('pages.My_Classes.My_Classes', compact('data'));
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
   

        try {
            $id = $request->id;
            
            // Prepare the data for the WordPress API
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'service' => $request->service,
                'phone' => $request->phone,
                'address' => $request->address // Note: fixing the spelling difference between form and API
            ];

            // Make the PUT request to WordPress API
            $response = Http::put("http://localhost/wordpress/wp-json/service-api/v1/requests/{$id}", $data);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Service request updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update service request');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    
}
  

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
// App/Http/Controllers/ServiceRequestController.php

public function destroy(Request $request)
{
    try {
        $id=$request->id;
        // Make the DELETE request to WordPress API
        $response = Http::delete("http://localhost/wordpress/wp-json/service-api/v1/requests/{$id}");

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Service request deleted successfully');

          
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete service request'
            ], 500);
        }

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
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