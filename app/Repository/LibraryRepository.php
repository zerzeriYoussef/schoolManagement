<?php

namespace App\Repository;

use App\Http\Traits\AttachFilesTrait;
use App\Models\Grade;
use App\Models\Library;
use App\Models\Librarys;
use App\Models\Section;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LibraryRepository implements LibraryRepositoryInterface
{

    //use AttachFilesTrait;

    public function index()
    {
        $books = Librarys::all();
        return view('pages.library.index',compact('books'));
    }

    public function create()
    {
        $grades = Grade::all();
        $sections=Section::all();
        return view('pages.library.create',compact('grades','sections'));
    }

    public function store($request)
    {
        try {
            $books = new Librarys();
            $books->title = $request->title;
            $books->file_name =  $request->file('file_name')->getClientOriginalName();
            $books->Grade_id = $request->Grade_id;
            $books->classroom_id = $request->Classroom_id;
            $books->section_id = $request->section_id;
            $books->teacher_id = 2;
            $books->save();
            //$this->uploadFile($request,'file_name');
          //  $file_name = $request->file($name)->getClientOriginalName();
         //   $request->file($name)->storeAs('attachments/library/',$file_name,'upload_attachments');
            $name = $request->file('file_name')->getClientOriginalName();
         //   $file->storeAs('attachments/students/'.$request->name_en, $file->getClientOriginalName(), 'upload_attachments');
            $request->file('file_name')->storeAs('attachments/library/',$name,'upload_attachments');
            Session::flash('success', trans('messages.success'));
            return redirect()->route('library.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $grades = Grade::all();
        $book = librarys::findorFail($id);
        return view('pages.library.edit',compact('book','grades'));
    }

    public function update($request)
    {
        try {

            $book = librarys::findorFail($request->id);
            $book->title = $request->title;

            if($request->hasfile('file_name')){

              //  $this->deleteFile($book->file_name);
              $exists = Storage::disk('upload_attachments')->exists('attachments/library/'.$book->file_name);

              if($exists)
              {
                  Storage::disk('upload_attachments')->delete('attachments/library/'.$book->file_name);
              }
              //  $this->uploadFile($request,'file_name');
              $name = $request->file('file_name')->getClientOriginalName();
                 $request->file('file_name')->storeAs('attachments/library/',$name,'upload_attachments');
     
                $file_name_new = $request->file('file_name')->getClientOriginalName();
                $book->file_name = $book->file_name !== $file_name_new ? $file_name_new : $book->file_name;
            }

            $book->Grade_id = $request->Grade_id;
            $book->classroom_id = $request->Classroom_id;
            $book->section_id = $request->section_id;
            $book->teacher_id = 1;
            $book->save();
            Session::flash('success', trans('messages.success'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
      //  $this->deleteFile($request->file_name);
      $book = librarys::findorFail($request->id);
      $book->title = $request->title;

      if($request->hasfile('file_name')){

        //  $this->deleteFile($book->file_name);
        $exists = Storage::disk('upload_attachments')->exists('attachments/library/'.$book->file_name);

        if($exists)
        {
            Storage::disk('upload_attachments')->delete('attachments/library/'.$book->file_name);
        }
        librarys::destroy($request->id);
        Session::flash('success', trans('messages.success'));
        return redirect()->route('library.index');
    }

  
}
  public function download($filename)
    {
        return response()->download(public_path('attachments/library/'.$filename));
    }
}