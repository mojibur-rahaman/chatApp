<?php

use App\Models\User;
use App\Models\chats;
use Inertia\Inertia; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\chats\chatController;

Route::inertia('/', 'home');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[authController::class,'dashboard']); 
    Route::post('/dashboard',[chatController::class,'message_store']);   
    Route::post('/logout',[authController::class,'logout']); 
});


Route::middleware('guest')->group(function(){ 
    Route::inertia('/register','Auth/register'); 
    Route::post('/register',[authController::class,'store']); 
    Route::inertia('/login','Auth/login'); 
    Route::post('/login',[authController::class,'login']); 
});


