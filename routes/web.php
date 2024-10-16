<?php

use App\Http\Controllers\GenerateQr;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', GenerateQr::class);
