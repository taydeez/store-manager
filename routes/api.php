<?php

//use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['ForceJson'])->group(function () {
    Route::post('/account/login', [AuthController::class, 'Login'])->name('account.login.api');
    Route::get('/test', fn() => ['message'=>'👑 Test area']);
});


Route::middleware(['auth:sanctum','ForceJson','client.auth'])->group(function () {
    Route::get('/admin-only', fn() => ['message'=>'👑 Admin only area']);
});
