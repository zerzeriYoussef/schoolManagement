<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {
        return view('auth.selection');
    }

  /*  public function dashboard()
    {
        // This method requires authentication to access
        return view('dashboard');
    }

    /**
     * Example method that requires admin access.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  /*  public function adminDashboard()
    {
        // This method requires admin authentication
        return view('admin.dashboard');
    }*/
}
