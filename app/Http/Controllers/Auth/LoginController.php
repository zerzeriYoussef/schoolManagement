<?php

namespace App\Http\Controllers\Auth;
use App\Http\Traits\AuthTrait;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


  //  use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/dashboard';
   use AuthTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  /*  public function showLoginForm()
    {
        return view('auth.login');
    }*/
    public function loginForm($type){

        return view('auth.login',compact('type'));
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request){
    // return  $this->chekGuard($request) ;
      if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
        
        return $this->redirect($request);
      }
      else{
        return redirect()->back()->with('message', 'password invalid       ');
    }

  }
  public function logout(Request $request,$type)
  {
      Auth::guard($type)->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return redirect('/');
  }
  public function ok()
  {
      return "ok";
  }

}
