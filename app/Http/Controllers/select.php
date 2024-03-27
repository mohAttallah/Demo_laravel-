<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class select extends Controller
{
public function index()
{
    $nextUrl = 'https://pokeapi.co/api/v2/pokemon'; 

    return view('welcome', ['nextUrl' => $nextUrl]);
}
}
