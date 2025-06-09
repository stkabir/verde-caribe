<?php

use Livewire\Volt\Volt;

Volt::route('/', 'users.index');
Volt::route('/productos', 'productos.index');
Volt::route('/gastos', 'gastos.index');
