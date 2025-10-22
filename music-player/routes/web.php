<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/player', function () {
    return view('player');
});

Route::view('/seed-music', 'seed-music');
