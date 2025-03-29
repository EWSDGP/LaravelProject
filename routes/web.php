<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClosureDateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\IdeaExportController;
use App\Http\Controllers\IdeaSubmissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\CheckIfBanned;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('Webadmin/dashboard');
})->name('dashboard');

Auth::routes();
Route::middleware([CheckIfBanned::class])->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('categories', CategoryController::class);
Route::resource('roles', RoleController::class);
Route::resource("users",UserController::class);
Route::resource('departments', DepartmentController::class);
Route::get('/ideas/closed', [IdeaSubmissionController::class, 'indexClosedIdeas'])->name('ideas.closed');
Route::resource('closure_dates', ClosureDateController::class);
Route::resource('ideas', IdeaSubmissionController::class);
Route::post('/ideas/{idea}/vote', [VoteController::class, 'vote'])->name('ideas.vote');
Route::get('/ideas/{idea_id}/check-vote', [IdeaSubmissionController::class, 'checkVote']);
Route::post('/comments/{idea}', [CommentController::class, 'store'])->name('comments.store');
Route::get('/ideas/export/combined', [IdeaExportController::class, 'exportCombined'])->name('ideas.export.combined');
Route::get('/settings/{section?}', [UserController::class, 'showSettings'])->name('settings');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
Route::get('/settings/login-history', [UserController::class, 'showLoginHistory'])->name('settings.login-history');
Route::post('/ideas/{idea}/report', [ReportController::class, 'store'])->name('ideas.report');
Route::get('/manage-reports', [ReportController::class, 'index'])->name('manage.reports.index');
Route::delete('/manage-reports/{id}', [ReportController::class, 'destroy'])->name('manage.reports.delete');
Route::post('/manage-reports/{user_id}/ban', [ReportController::class, 'banUser'])->name('manage.reports.ban');
Route::post('/manage-reports/{user_id}/unban', [ReportController::class, 'unbanUser'])->name('manage.reports.unban');
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index'); 


});