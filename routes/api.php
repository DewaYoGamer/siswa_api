<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;

//ONLY ADMIN
Route::middleware(['auth:sanctum', 'check_admin'])->prefix('admin')->group(function () {
    Route::apiResource('student', StudentController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('schedule', ScheduleController::class)->only(['show', 'store', 'update', 'destroy']);
    Route::apiResource('classroom', ClassroomController::class);
    Route::apiResource('subject', SubjectController::class);
    Route::apiResource('teacher', TeacherController::class)->except(['index']);
    Route::post('student_active', [StudentController::class, 'changeActive']);
});

//ONLY ACTIVE STUDENT
Route::middleware(['auth:sanctum', 'active_student'])->group(function () {
    Route::apiResource('schedule', ScheduleController::class)->only(['index']);
    Route::get('profile', [StudentController::class, 'profile']);
    Route::post('set_schedule', [ScheduleController::class, 'setStudentSchedule']);
    Route::apiResource('teacher', TeacherController::class)->only(['index']);
});

//PUBLIC
Route::post('login', [StudentController::class, 'login']);
Route::post('register', [StudentController::class, 'store']);
