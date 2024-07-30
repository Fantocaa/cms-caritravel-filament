<?php

use App\Http\Controllers\travel_packages;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/admin/login');
});

Route::get('/traveldata', [travel_packages::class, "index"]);

Route::get('/visadata', [travel_packages::class, "visadata"]);
