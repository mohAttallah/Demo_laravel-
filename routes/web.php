<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\select;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [select::class, 'index']);

Route::get('/about', function () {
    return view('about');
});

Route::get("/store/query", function(){
    $fillter = request('style');
    if(isset($fillter)){
        return 'this is a viewing page ' . $fillter;
    }
});

Route::get("/store/params/{style?}", function($style = null){
    if(isset($style)){
        return 'This is a viewing page ' . $style;
    }
});


Route::fallback(function () {
    $route = request()->url(); // Get the current URL
    return response("<h3>404 Not Found - Current Route: $route</h3>", 404);
});
