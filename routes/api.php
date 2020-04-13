<?php

use Illuminate\Support\Facades\Route;


Route::post('register', 'ApiSecurity@register');
Route::post('login', 'ApiSecurity@login');
Route::post('logout', 'ApiSecurity@logout');

Route::get('unlogged', function() {
    return response()->json([
        'error' => 'Tienes que iniciar sesion primero'
    ], 400);
})->name('unlogged');

Route::resource('producto', 'ApiProducto')->middleware('auth:sanctum');