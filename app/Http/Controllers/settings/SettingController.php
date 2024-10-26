<?php

namespace App\Http\Controllers\settings;

//use App\Http\Traits\AttachFilesTrait;

use App\Http\Controllers\Controller;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    //use AttachFilesTrait;
    public function index(){

        $collection = settings::all();
        $setting['setting'] = $collection->flatMap(function ($collection) {
            return [$collection->key => $collection->value];
        });
        return view('pages.setting.index', $setting);
    }

    public function update(Request $request){

        try{
            $info = $request->except('_token', '_method', 'logo');
           foreach ($info as $key=> $value){
                settings::where('key', $key)->update(['value' => $value]);
            }

//            $key = array_keys($info);
//            $value = array_values($info);
//            for($i =0; $i<count($info);$i++){
//                Setting::where('key', $key[$i])->update(['value' => $value[$i]]);
//            }

            if($request->hasFile('logo')) {
                $logo_name = $request->file('logo')->getClientOriginalName();
                settings::where('key', 'logo')->update(['value' => $logo_name]);
                $request->file('logo')->storeAs('attachments/logo',$logo_name,'upload_attachments');
     
                // $file_name_new = $request->file('file_name')->getClientOriginalName();
              //  $book->file_name = $book->file_name !== $file_name_new ? $file_name_new : $book->file_name;

              //  $this->uploadFile($request,'logo','logo');
            }

            Session::flash('success', trans('messages.Update'));
            return back();
        }
        catch (\Exception $e){

            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
}