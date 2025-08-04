<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

// Volt::route('/', 'users.index');
// Volt::route('/productos', 'productos.index');
Volt::route('/gastos', 'gastos.index');
Volt::route('/categorias', 'categorias.index');

Route::view('/', 'landing')->name('landing');

Route::fallback(function () {
    return redirect()->route('landing');
});