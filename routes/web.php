<?php


use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// // web.php
// Route::get('/login/microsoft', [AuthController::class, 'redirectToProvider'])->name('sso.redirect');
// Route::get('/login/microsoft/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('/login', function () {
    return view('admin.pages.admin.login');
})->name('admin.login');


Route::get('/', function () {
    return view('welcome');
})->name('client.home');


Route::get('/dashboard', function () {
    return view('admin.pages.admin.dashboard');
})->name('admin.dashboard');

Route::get('/department', function () {
    return view('admin.pages.admin.department');
})->name('admin.department.index');

Route::get('/create-department', function () {
    return view('admin.pages.admin.create-department');
})->name('admin.department.create-department');

Route::get('/major', function () {
    return view('admin.pages.admin.major');
})->name('admin.major.index');

Route::get('/create-major', function () {
    return view('admin.pages.admin.create-major');
})->name('admin.major.create-major');

Route::get('/class', function () {
    return view('admin.pages.admin.class');
})->name('admin.class.index');


Route::get('/edit-major', function () {
    return view('admin.pages.admin.edit-major');
})->name('admin.major.edit-major');


Route::get('/edit-department', function () {
    return view('admin.pages.admin.edit-department');
})->name('admin.department.edit-department');


Route::get('/edit-class', function () {
    return view('admin.pages.admin.edit-class');
})->name('admin.class.edit-class');


Route::get('/create-class', function () {
    return view('admin.pages.admin.create-class');
})->name('admin.class.create-class');

Route::get('/survey', function () {
    return view('admin.pages.admin.survey');
})->name('admin.survey.index');

Route::get('/create-survey', function () {
    return view('admin.pages.admin.create-survey');
})->name('admin.survey.create-survey');

Route::get('/class-detail;', function () {
    return view('admin.pages.admin.class-detail');
})->name('admin.class.class-detail');

Route::get('/form-survey;', function () {
    return view('admin.pages.admin.form-survey');
})->name('admin.survey.form-survey');

Route::get('/form-edit-survey;', function () {
    return view('admin.pages.admin.form-edit-survey');
})->name('admin.survey.form-edit-survey');

Route::get('/graduation;', function () {
    return view('admin.pages.admin.graduation');
})->name('admin.graduation.index');

Route::get('/infor-account;', function () {
    return view('admin.pages.admin.infor-account');
})->name('admin.infor-account.index');

Route::get('/edit-profile;', function () {
    return view('admin.pages.admin.edit-profile');
})->name('admin.infor-account.edit-profile');

Route::get('/change-password;', function () {
    return view('admin.pages.admin.change-password');
})->name('admin.infor-account.change-password');

Route::get('/login/sso', [AuthController::class, 'redirectToSSO'])->name('sso.redirect');
Route::get('/login/sso/callback', [AuthController::class, 'handleSSOCallback'])->name('sso.callback');

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');