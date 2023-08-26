<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('students/create', [StudentController::class, 'create']);
    Route::post('students/add', [StudentController::class, 'addStudentToPeriod']);
    Route::put('students/{id}', [StudentController::class, 'edit']);
    Route::delete('students/{id}', [StudentController::class, 'delete']);
    Route::delete('student/remove', [StudentController::class, 'removeStudentToPeriod']);
    Route::get('student/fetch/{id}', [StudentController::class, 'fetchAllByPeriod']);
    Route::get('student/fetchAll', [StudentController::class, 'fetchAllByPeriodAndByTeacher']);

    Route::post('teachers/create', [TeacherController::class, 'create']);
    Route::put('teachers/{id}', [TeacherController::class, 'edit']);
    Route::delete('teachers/{id}', [TeacherController::class, 'delete']);

    Route::post('periods/create', [PeriodController::class, 'create']);
    Route::put('periods/{id}', [PeriodController::class, 'edit']);
    Route::delete('periods/{id}', [PeriodController::class, 'delete']);
    Route::get('periods/fetch/{id}', [PeriodController::class, 'fetchAllByTeacher']);
});
