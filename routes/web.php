<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Usuarios;
use App\Livewire\Teacher;
use App\Livewire\Payments;
use App\Livewire\Students;
use App\Livewire\Lessons;
use App\Livewire\Inscriptions;
use App\Livewire\Roles;
use App\Livewire\Dashboard;
use App\Models\Role;
use App\Livewire\Schedules;
use App\Livewire\Liquidations;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register', ['roles' => Role::all()]);
})->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

// Prefijo para usuarios
    Route::prefix('usr')->group(function () {
        Route::get('r', Usuarios::class)->lazy()->name('usr.r'); // Leer usuarios
        Route::post('c', [Usuarios::class, 'save'])->name('usr.c'); // Crear usuario
    });

// Prefijo para los usuarios de tipo maestro
    Route::prefix('tch')->group(function () {
        Route::get('r', Teacher::class)->lazy()->name('tch.r'); 
    });

// Prefijo para los pagos
    Route::prefix('pym')->group(function () {
        Route::get('r', Payments::class)->lazy()->name('pym.r'); 
    });

// Prefijo para las clases de baile
    Route::prefix('lsn')->group(function () {
        Route::get('r', Lessons::class)->lazy()->name('lsn.r'); 
    });

//Prefijo para horarios
    Route::prefix('sch')->group(function () {
        Route::get('r', Schedules::class)->lazy()->name('sch.r'); 
    });

// Prefijo para los estudiantes
    Route::prefix('std')->group(function () {
        Route::get('r', Students::class)->lazy()->name('std.r'); 
    });

// Prefijo para las isncrpciones
    Route::prefix('ncp')->group(function () {
        Route::get('r', Inscriptions::class)->lazy()->name('ncp.r'); 
    });

// Prefijo para la dashboard
    Route::prefix('dsh')->group(function () {
        Route::get('r', Dashboard::class)->lazy()->name('dsh.r');
        Route::post('usr/c', [Dashboard::class, 'saveUser'])->name('usr/c'); // Crear usuario
    });

// Prefijo para los roles
    Route::prefix('rl')->group(function () {
        Route::get('r', Roles::class)->lazy()->name('rl.r'); 
    });

// Prefijo para las liquidaciones
    Route::prefix('lqd')->group(function () {
        Route::get('r', Liquidations::class)->lazy()->name('lqd.r'); 
    });

});
