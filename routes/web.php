<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login',function(){
    return view('Components/login');
});

Route::get('/dashboard',function(){
    return view('Webadmin/dashboard');
});