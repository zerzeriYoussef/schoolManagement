<?php

namespace App\Http\Traits;

use App\Providers\RouteServiceProvider;

trait AuthTrait
{
    public function chekGuard($request)
    {
        switch ($request->type) {
            case 'student':
                return 'student';
            case 'parent':
                return 'parent';
            case 'teacher':
                return 'teacher';
            default:
                return 'web';
        }
    }
    

    public function redirect($request){

        if($request->type == 'student'){
            return redirect()->intended(RouteServiceProvider::STUDENT);
        }
        elseif ($request->type == 'parent'){
            return redirect()->intended(RouteServiceProvider::PARENT);
        }
        elseif ($request->type == 'teacher'){
            return redirect()->intended(RouteServiceProvider::TEACHER);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}