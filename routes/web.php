<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to(url('/admin'));
    return view('welcome');
});
