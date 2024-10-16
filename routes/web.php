<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function (Request $request) {
    dd($request->input('linkToConvert'), $request->input('qrColor'), $request->input('qrType'));
    return view('welcome');
});
