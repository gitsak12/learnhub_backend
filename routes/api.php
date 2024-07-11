<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseControllerApi;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['namespace' => 'Api'], function () {
    Route::post('/login', [UserController::class, 'login']);

    //authentication middleware: tell which auth we are using
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::any('/courseList', [CourseControllerApi::class, 'courseList']);
        Route::any('/courseDetail', [CourseControllerApi::class, 'courseDetail']);
        Route::any('/coursesSearchDefault', [CourseControllerApi::class, 'coursesSearchDefault']);
        Route::any('/coursesSearch', [CourseControllerApi::class, 'coursesSearch']);
        Route::any('/lessonList', [LessonController::class, 'lessonList']);
        Route::any('/lessonDetail', [LessonController::class, 'lessonDetail']);
        //Route::any('/checkout', [PaymentController::class, 'checkout']);


        Route::any('/authorCourseList', [CourseControllerApi::class, 'authorCourseList']);
        Route::any('courseAuthor', [CourseControllerApi::class, 'courseAuthor']);
    });
});