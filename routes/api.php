<?php

//======================> Importar Clases <======================
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
//======================> Importar Controladores <======================
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AcademyController;
use App\Http\Controllers\Api\V1\LessonController;
use App\Http\Controllers\Api\V1\PayController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Models\Pay;

//================================================> V1 API  <==================================================================
Route::prefix('v1')->group(function () {

    //================================================> Auth  <==================================================================
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(JwtMiddleware::class);
        Route::get('/refreshToken', [AuthController::class, 'refresh'])->middleware(JwtMiddleware::class);
        // Route::get('/refreshToken', [AuthController::class, 'refreshToken'])->middleware(JwtMiddleware::class);
    });
    //=====================================================> Usuarios <=================================================================
    Route::prefix('/users')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware([JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante']);
        Route::get('/{id}', [UserController::class, 'show'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::post('', [UserController::class, 'store'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::patch('/{id}', [UserController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
    });

    //=====================================================> Academias <=================================================================
    Route::prefix('/academies')->group(function () {
        Route::get('', [AcademyController::class, 'index'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::get('/{id}', [AcademyController::class, 'show'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::post('', [AcademyController::class, 'store'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::patch('/{id}', [AcademyController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::put('/{id}', [AcademyController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
    });

    //=====================================================> Servicios <=================================================================
    Route::prefix('/services')->group(function () {
        Route::get('', [ServiceController::class, 'index'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::get('/{id}', [ServiceController::class, 'show'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::post('', [ServiceController::class, 'store'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::patch('/{id}', [ServiceController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::put('/{id}', [ServiceController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
    });

    //=====================================================> Cursos <=================================================================
    Route::prefix('/lessons')->group(function () {
        Route::get('', [LessonController::class, 'index'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::get('/{id}', [LessonController::class, 'show'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::post('', [LessonController::class, 'store'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::patch('/{id}', [LessonController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
    });

    //=====================================================> Pagos <=================================================================
    Route::prefix('/payments')->group(function () {
        Route::get('', [PayController::class, 'index'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::get('/{id}', [PayController::class, 'show'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin|Profesor|Estudiante');
        Route::post('', [PayController::class, 'store'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
        Route::patch('/{id}', [PayController::class, 'update'])->middleware(JwtMiddleware::class . ':SuperAdmin|Admin');
    });
});
