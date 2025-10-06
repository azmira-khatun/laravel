<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');


});
Route::get('/h', function () {
    return view('home  ');


});
Route::get('/add', function () {
    return view('pages.add-user  ');


});
Route::get('/manage', function () {
    return view('pages.manage-user  ');


});
Route::get('/master', function () {
    return view('master  ');


});





