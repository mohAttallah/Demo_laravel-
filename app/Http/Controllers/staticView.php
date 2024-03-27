<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class staticView extends Controller
{
    public function index (){
        return view('staticPage');
    }
}
