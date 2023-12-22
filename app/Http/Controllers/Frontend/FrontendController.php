<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
   public function index(){
    return view('frontend.modules.index');
   }
      public function login(){
    return view('frontend.modules.login');
   }
}
