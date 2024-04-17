<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task',[TaskController::class,'index']);
Route::get('/tasks',[TaskController::class,'tasks'])->name('tasks');
Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create');
Route::get('/tasks/edit/{id}',[TaskController::class,'edit'])->name('tasks.edit');
Route::post('/store',[TaskController::class,'store'])->name('store.task');
Route::get('/tasks/{id}', [TaskController::class,'complete'])->name('tasks.complete');
Route::PUT('/update/{id}',[TaskController::class,'update'])->name('update.task');
Route::get('/items/{id}',[TaskController::class,'destroy'])->name('tasks.delete');


