<?php

//use App\Http\Middleware\ForceJsonResponse;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\StoreInventoryController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware(['ForceJson', 'client.auth'])->group(function () {
    Route::post('/account/login', [AuthController::class, 'Login'])->middleware('throttle:5,1');;
    Route::post('/account/password/forgot', [AuthController::class, 'sendCode'])->middleware('throttle:5,1');;
    Route::post('/account/password/verify', [AuthController::class, 'verifyCode'])->middleware('throttle:5,1');;
    Route::post('/account/password/reset', [AuthController::class, 'resetPassword']);
    Route::post('/account/refresh', [AuthController::class, 'refresh'])->middleware('throttle:5,1');

    Route::get('/up', fn() => ['message' => '👑 Running']);

    Route::get('/health', function () {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now(),
        ]);
    });

    Route::get('/health/deep', function () {
        $checks = [];

        // Database
        try {
            DB::connection()->getPdo();
            $checks['database'] = 'ok';
        } catch (\Exception $e) {
            $checks['database'] = 'failed';
        }

//        // Redis
//        try {
//            Redis::set('health', 'ok');
//            $checks['redis'] = Redis::get('health') === 'ok' ? 'ok' : 'failed';
//        } catch (\Exception $e) {
//            $checks['redis'] = 'failed';
//        }

        // Storage
//        try {
//            Storage::disk('gcs')->put('health.txt', 'ok');
//            $checks['storage'] = 'ok';
//            Storage::disk('gcs')->delete('health.txt');
//        } catch (\Exception $e) {
//            $checks['storage'] = 'failed';
//        }

        $healthy = collect($checks)->every(fn($v) => $v === 'ok');

        return response()->json([
            'status' => $healthy ? 'healthy' : 'unhealthy',
            'checks' => $checks,
        ], $healthy ? 200 : 503);
    });


});


Route::middleware(['jwt.auth', 'ForceJson', 'client.auth'])->group(function () {

    //users
    Route::get('/account/users', [AuthController::class, 'index'])->name('users')->middleware('role:admin');
    Route::get('/account/user', [AuthController::class, 'getUser'])->name('user.api');
    Route::get('/account/user/{id}', [AuthController::class, 'getUser'])->name('user.account.api');
    Route::post('/account/create', [AuthController::class, 'createUser'])->name('user.create.api');
    Route::patch('/account/update', [AuthController::class, 'updateUser'])->name('user.update.api');


    //Book routes
    Route::get('/books', [BooksController::class, 'index'])->name('books.index')->middleware('role:admin');
    Route::get('/books/{id}', [BooksController::class, 'show'])->name('books.show')->middleware('role:admin');
    Route::post('/books', [BooksController::class, 'store'])->name('books.store')->middleware('role:admin');
    Route::post('/books/update/{id}',
        [BooksController::class, 'update'])->name('books.update')->middleware('role:admin');
    Route::delete('/books/{id}', [BooksController::class, 'destroy'])->name('books.destroy')->middleware('role:admin');
    Route::patch('/books/shelf/{id}',
        [BooksController::class, 'shelf'])->name('books.shelve')->middleware('role:admin');


    //Stock Management route
    Route::post('/stock/update',
        [StockController::class, 'updateStock'])->name('stock.update')->middleware('role:admin');

    // Manage Store fronts
    Route::apiResource('/storefronts', StoreFrontController::class)->scoped()->middleware('role:admin');


    //Store inventory
    Route::get('/storeinventory', [StoreInventoryController::class, 'index'])->middleware('role:admin');
    Route::post('/storeinventory', [StoreInventoryController::class, 'createInventory'])->middleware('role:admin');
    Route::patch('/storeinventory/update',
        [StoreInventoryController::class, 'updateInventory'])->middleware('role:admin');


    //Customers
    Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index'])->middleware('role:admin');
    Route::get('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'show'])->middleware('role:admin');
    Route::post('/customers', [\App\Http\Controllers\CustomerController::class, 'store'])->middleware('role:admin');
    Route::delete('/customers/{id}',
        [\App\Http\Controllers\CustomerController::class, 'destroy'])->middleware('role:admin');


    //orders
    Route::get('/orders', [OrdersController::class, 'index'])->middleware('role:admin');
    Route::post('/orders', [OrdersController::class, 'createOrder'])->middleware('role:admin');
    Route::post('/orders/cancel', [OrdersController::class, 'cancelOrder'])->middleware('role:admin');


    //statistics
    Route::get('/statistics/monthly-sales', [StatisticsController::class, 'monthlySalesStatistics'])->middleware('role:admin');

    Route::get('/statistics/best-sellers', [StatisticsController::class, 'bestSellers'])->middleware('role:admin');

    Route::get('/statistics/out-of-stock', [StatisticsController::class, 'lowAndOutofStock'])->middleware('role:admin');

    //RABC
    Route::get('/rbac/roles',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'index'])->middleware('role:admin');

    Route::post('/rbac/role/create',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'create'])->middleware('role:admin');

    Route::post('/rbac/role/update',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'updatePermissions'])->middleware('role:admin');


    Route::get('/rbac/permissions',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'permissions'])->middleware('role:admin');

    Route::get('/admin-only', fn() => ['message' => ' Admin only area']);


});
