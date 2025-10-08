<?php

//use App\Http\Middleware\ForceJsonResponse;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\StoreInventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['ForceJson'])->group(function () {
    Route::post('/account/login', [AuthController::class, 'Login'])->name('account.login.api');
    Route::get('/up', fn() => ['message'=>'👑 Running']);
});


Route::middleware(['auth:sanctum','ForceJson','client.auth'])->group(function () {

    //users
    Route::get('/users',[AuthController::class, 'index'])->name('users')->middleware('role:admin');



    //Book routes
    Route::get('/books',  [BooksController::class, 'index'])->name('books.index')->middleware('role:admin');
    Route::get('/books/{id}',  [BooksController::class, 'show'])->name('books.show')->middleware('role:admin');
    Route::post('/books', [BooksController::class, 'store'])->name('books.store')->middleware('role:admin');
    Route::post('/books/update/{id}', [BooksController::class, 'update'])->name('books.update')->middleware('role:admin');
    Route::delete('/books/{id}',  [BooksController::class, 'destroy'])->name('books.destroy')->middleware('role:admin');
    Route::patch('/books/shelf/{id}', [BooksController::class, 'shelf'])->name('books.shelve')->middleware('role:admin');


    //Stock Management routes
    Route::post('/stock/update',  [StockController::class, 'updateStock'])->name('stock.update')->middleware('role:admin');

    // Manage Store fronts
    Route::apiResource('storefronts', StoreFrontController::class)->scoped()->middleware('role:admin');


    //Store inventory
    Route::get('storeinventory', [StoreInventoryController::class,'index'])->middleware('role:admin');
    Route::post('storeinventory', [StoreInventoryController::class,'createInventory'])->middleware('role:admin');
    Route::patch('storeinventory/update', [StoreInventoryController::class,'updateInventory'])->middleware('role:admin');



    Route::get('/admin-only', fn() => ['message'=>' Admin only area']);
});
