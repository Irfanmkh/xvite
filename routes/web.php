<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/', function () {
    return view('welcome');
});

//  Route::get('/preview/{id}', [ViewController::class, 'beritaByTipe'])->name('berita.bytipe');
// Route::get('/preview/tema/{id}', [ViewController::class, 'temaView'])->name('tema.preview');
Route::get('/tema/{id}', [ViewController::class, 'temaView'])->name('tema.view');
