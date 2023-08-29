<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->get('/', 'HomeController@index')->name('home.index');
Route::get('/#register', 'HomeController@index')->name('home.register');
Route::post('/contact', 'HomeController@contact')->name('home.contact');
Route::get('/home', 'HomeController@homeredir')->name('home');