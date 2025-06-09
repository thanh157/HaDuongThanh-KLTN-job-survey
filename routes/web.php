<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('client.home');


Route::get('/dashboard', function () {
    return view('admin.pages.admin.dashboard');
})->name('admin.dashboard');

Route::get('/department', function () {
    return view('admin.pages.admin.department');
})->name('admin.department');

Route::get('/create-department', function () {
    return view('admin.pages.admin.create-department');
})->name('admin.create-department');

Route::get('/major', function () {
    return view('admin.pages.admin.major');
})->name('admin.major');

Route::get('/create-major', function () {
    return view('admin.pages.admin.create-major');
})->name('admin.create-major');

Route::get('/class', function () {
    return view('admin.pages.admin.class');
})->name('admin.class');


Route::get('/edit-major', function () {
    return view('admin.pages.admin.edit-major');
})->name('admin.edit-major');


Route::get('/edit-department', function () {
    return view('admin.pages.admin.edit-department');
})->name('admin.edit-department');


Route::get('/edit-class', function () {
    return view('admin.pages.admin.edit-class');
})->name('admin.edit-class');


Route::get('/create-class', function () {
    return view('admin.pages.admin.create-class');
})->name('admin.create-class');