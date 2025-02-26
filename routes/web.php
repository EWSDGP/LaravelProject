<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClosureDateController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login',function(){
    return view('Components/login');
});

Route::get('/dashboard',function(){
    return view('Webadmin/dashboard');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('categories', CategoryController::class);
Route::resource('roles', RoleController::class);
Route::resource("users",UserController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('closure_dates', ClosureDateController::class);
