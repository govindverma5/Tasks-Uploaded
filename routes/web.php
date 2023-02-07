<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('tasks',        [App\Http\Controllers\TasksController::class,'index'])->name('tasks.index');
Route::get('tasks/create', [App\Http\Controllers\TasksController::class,'create'])->name('tasks.create');
Route::get('tasks/delete', [App\Http\Controllers\TasksController::class, 'destroy'])->name('tasks.delete');
Route::get('tasks/status', [App\Http\Controllers\TasksController::class, 'status'])->name('tasks.status');
Route::get('tasks/show', [App\Http\Controllers\TasksController::class,  'show'])->name('tasks.show');

