<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GroupsController;

Route::get('/', function () {
    return 'hello world';
})->name('home');

Route::get('/getGroups', [GroupsController::class, 'getAllGroups']);
Route::get('/getProducts', [ProductsController::class, 'getByPage']);
Route::get('/getProductInfo', [ProductsController::class, 'getProductInfo']);
Route::get('/getAmountOfProducts', [ProductsController::class,'getAmountOfProducts']);
Route::get('/getBreadcrumbs', [GroupsController::class,'getProductBreadcrumbs']);
