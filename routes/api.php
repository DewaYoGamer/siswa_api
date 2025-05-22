<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;

Route::apiResource('student', StudentController::class);
Route::apiResource('schedule', ScheduleController::class);
Route::apiResource('classroom', ClassroomController::class);
Route::apiResource('subject', SubjectController::class);
Route::apiResource('teacher', TeacherController::class);
Route::post('student/set_schedule', [ScheduleController::class, 'setStudentSchedule']);

Route::post('login', [StudentController::class, 'login']);
