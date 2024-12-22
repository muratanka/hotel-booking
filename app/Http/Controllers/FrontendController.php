<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class FrontendController extends Controller
{
  public function home()
  {
    return view('home');
  }
}
