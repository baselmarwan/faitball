<?php

use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('register1', [AuthController::class, 'registerStepOne'])->name('user.registerStepOne');
Route::post('register2', [AuthController::class, 'registerStepTwo'])->name('user.registerStepTwo');
Route::post('login', [AuthController::class, 'login'])->name('user.login');
Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
Route::get('get-photo', [AuthController::class, 'getPhoto'])->name('user.getPhoto');

Route::resource('academies', AcademyController::class);
Route::get('academy-get-photo', [AcademyController::class,'getPhoto'])->name('academy.getPhoto');
Route::get('get-user-academies',[UserController::class,'getUserAcademies'])->name('user.getUserAcademies');
Route::get('get-user-name-photo',[UserController::class,'gitUserNamePhoto'])->name('user.getUserNamePhoto');
Route::get('get-user-information',[UserController::class,'gitUserInformation'])->name('user.getUserInformation');
Route::resource('trainers',TrainerController::class);
Route::resource('players',PlayersController::class);
Route::get('academy-get-details', [AcademyController::class,'getAcademyDetails'])->name('academy.getDetails');
Route::get('all-academies-get-details', [AcademyController::class,'getAllAcademyDetails'])->name('academy.getAllDetails');
Route::get('switch-academy',[UserController::class,'switchAcademy'])->name('user.switch-academy');
Route::get('resend-code',[VerifyController::class,'resendCode'])->name('user.resend-code');
Route::get('check-your-phone',[VerifyController::class,'checkYourPhone'])->name('user.check-your-phone');
