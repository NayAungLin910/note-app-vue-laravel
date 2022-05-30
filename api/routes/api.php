<?php

use App\Http\Controllers\AuthApi;
use App\Http\Controllers\NoteApi;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApi::class, 'register']);
Route::post('/login', [AuthApi::class, 'login']);

Route::middleware(['auth:api',])->group(function(){
    Route::post('/note/create',  [NoteApi::class, 'create']);
    Route::get('/colorlabel',  [NoteApi::class, 'ColorLabel']);
    Route::get('/note/', [NoteApi::class, 'all']);
});

Route::get('/need/login', function(){
    return response()->json([
        'success'=>false,
        'status'=>500,
        'data'=>"need_login",
    ]);
})->name('login');