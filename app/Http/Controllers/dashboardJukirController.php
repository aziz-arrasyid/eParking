<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardJukirController extends Controller
{
    public function index(){
        return view('jukir.index');
    }
}
