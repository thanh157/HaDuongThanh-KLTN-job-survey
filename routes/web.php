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


