<?php

use App\Http\Controllers\travel_packages;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/admin/login');
});

Route::get('/traveldata', [travel_packages::class, "index"]);

Route::get('/traveldata/recomendation', [travel_packages::class, "recomendation"]);

Route::get('/visadata', [travel_packages::class, "visadata"]);

Route::get('/product_location', [travel_packages::class, "product_location"]);

Route::get('/visa_country', [travel_packages::class, "visa_country"]);
