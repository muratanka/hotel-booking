<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
  public function dashboard()
  {
    Log::info("Admin Dashboard View is being loaded.");
    return view('dashboard'); // 'admin.dashboard' yerine sadece 'dashboard' kullanılıyor.
  }
}
