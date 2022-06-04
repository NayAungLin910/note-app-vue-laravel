<?php

use App\Http\Controllers\AuthApi;
use App\Http\Controllers\ContributeController;
use App\Http\Controllers\NoteApi;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApi::class, 'register']);
Route::post('/login', [AuthApi::class, 'login']);

Route::middleware(['auth:api',])->group(function(){
    Route::post('/note/create',  [NoteApi::class, 'create']);
    Route::post('/label/create',  [NoteApi::class, 'labelCreate']);
    Route::get('/note/{slug}',  [NoteApi::class, 'detail']);
    Route::post('/note/edit/{slug}',  [NoteApi::class, 'update']);
    Route::get('/colorlabel',  [NoteApi::class, 'ColorLabel']);
    Route::get('/note/', [NoteApi::class, 'all']);
    Route::get('/note/label/{slug}', [NoteApi::class, 'noteByLabel']);

    Route::get('/find/user/{email}', [ContributeController::class, 'findUser']);
    Route::post('/contribute/', [ContributeController::class, 'contribute']);
});

Route::get('/need/login', function(){
    return response()->json([
        'success'=>false,
        'status'=>500,
        'data'=>"need_login",
    ]);
})->name('login');