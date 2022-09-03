<?php

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

//STUDENTS
Route::get('/students', 'StudentController@index');
Route::get('/student/{id}', 'StudentController@show');
Route::post('/student-create', 'StudentController@store');
Route::post('/student-edit', 'StudentController@edit');

//TEACHERS
Route::get('/teachers', 'TeacherController@index');
Route::get('/teacher/{id}', 'TeacherController@show');
Route::post('/teacher-create', 'TeacherController@store');
Route::post('/teacher-edit', 'TeacherController@edit');

//COURSES
Route::get('/courses', 'CourseController@index');
Route::get('/list-courses', 'CourseController@list');
Route::post('/create-course', 'CourseController@store');

//SUBSCRIPTION
Route::post('/subscribe-student', 'SubscriptionController@singleSubscribe');
Route::post('/unsubscribe-student/{id}', 'SubscriptionController@endSubscription');
Route::post('/resubscribe-student', 'SubscriptionController@reactiveSubscription');

//TEACHERS COURSES
Route::post('/hire-teacher', 'TeacherController@singleHireTeacher');
Route::post('/fire-teacher/{id}', 'TeacherController@fireTeacher');
Route::post('/re-hire-teacher', 'TeacherController@reHireTeacher');

//PAYMENTS
Route::get('/check-payments', 'PaymentsController@checkPayments');
Route::post('/pay-course/{id}', 'PaymentsController@payCourse');
Route::post('/cancel-payment/{id}', 'PaymentsController@cancelPayment');
Route::post('/undo-payment/{id}', 'PaymentsController@undoPayment');

//SALARIES
Route::get('/check-salaries', 'SalariesController@checkSalary');
Route::post('/pay-salary', 'SalariesController@paySalary');
Route::post('/cancel-salary/{id}', 'SalariesController@cancelSalary');
Route::post('/undo-salary/{id}', 'SalariesController@undoSalary');
