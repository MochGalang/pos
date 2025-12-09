<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Home;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  return redirect('/home');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('order', [OrderController::class, 'index']);
Route::post('order', [OrderController::class, 'store'])->name('order.store');
Route::get('order/{order}/print', [OrderController::class, 'print'])->name('order.print');
