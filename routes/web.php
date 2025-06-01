<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('client.home');


Route::get('/admin/dashboard', function () {
    return view('admin.pages.admin.dashboard');
})->name('admin.dashboard');
