<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');


});
Route::get('/h', function () {
    return view('home  ');


});
Route::get('/add-user', function () {
    return view('pages.user  ');


});




