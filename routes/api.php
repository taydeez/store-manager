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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;

Route::get('/test', [BooksController::class, 'test']);

//health checks
Route::get('/health/deep', function () {
    $checks = [];

    // Database
    try {
        DB::connection()->getPdo();
        $checks['database'] = 'ok';
    } catch (\Exception $e) {
        $checks['database'] = 'failed';
        dd($e->getMessage());
    }

    // Redis
    try {
        Redis::set('health', 'ok');
        $checks['redis'] = Redis::get('health') === 'ok' ? 'ok' : 'failed';
    } catch (\Exception $e) {
        $checks['redis'] = 'failed';
    }

    //Storage
    try {
        Storage::disk()->put('health.txt', 'ok');
        $checks['storage'] = 'ok';
        Storage::disk()->delete('health.txt');
    } catch (\Exception $e) {
        $checks['storage'] = $e->getMessage();
    }

    $healthy = collect($checks)->every(fn($v) => $v === 'ok');

    return response()->json([
        'status' => $healthy ? 'healthy' : 'unhealthy',
        'checks' => $checks,
    ], $healthy ? 200 : 503);
});


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
});


Route::middleware(['jwt.auth', 'ForceJson', 'client.auth'])->group(function () {
    //users
    Route::get('/account/users', [AuthController::class, 'index'])->middleware('permission:manage_users');
    Route::get('/account/user', [AuthController::class, 'getUser']);
    Route::get('/account/user/{id}', [AuthController::class, 'getUser']);
    Route::post('/account/create', [AuthController::class, 'createUser'])->middleware('permission:add_users');
    Route::patch('/account/update', [AuthController::class, 'updateUser'])->middleware('permission:manage_users');


    //Book routes
    Route::get('/books', [BooksController::class, 'index'])->middleware('permission:list_all_books');
    Route::get('/books/{id}', [BooksController::class, 'show'])->middleware('permission:list_all_books');
    Route::post('/books', [BooksController::class, 'store'])->middleware('permission:add_books');
    Route::post(
        '/books/update/{id}',
        [BooksController::class, 'update']
    )->middleware('permission:edit_books');
    Route::delete('/books/{id}', [BooksController::class, 'destroy'])->middleware('role:admin');
    Route::patch(
        '/books/shelf/{id}',
        [BooksController::class, 'shelf']
    )->middleware('permission:edit_books');


    //Stock Management route
    Route::post(
        '/stock/update',
        [StockController::class, 'updateStock']
    )->middleware('permission:manage_all_stock|manage_store_stock');

    // Manage Store fronts
    Route::apiResource('/storefronts', StoreFrontController::class)->middleware(
        'permission:list_all_stores|manage_all_stores|manage_store_stock'
    );


    //Store inventory
    Route::get('/storeinventory', [StoreInventoryController::class, 'index'])->middleware(
        'permission:list_all_stores|manage_all_stock|manage_store_stock|sell_books'
    );
    Route::post('/storeinventory', [StoreInventoryController::class, 'createInventory'])->middleware(
        'permission:update_inventory'
    );
    Route::patch(
        '/storeinventory/update',
        [StoreInventoryController::class, 'updateInventory']
    )->middleware('permission:update_inventory');


    //Customers
    Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index'])->middleware(
        'permission:list_all_customers'
    );
    Route::get('/customers/{phone_number}', [\App\Http\Controllers\CustomerController::class, 'show'])->middleware(
        'permission:sell_books|list_all_customers'
    );
    Route::post('/customers', [\App\Http\Controllers\CustomerController::class, 'store'])->middleware(
        'permission:sell_books|list_all_customers'
    );
    Route::delete(
        '/customers/{id}',
        [\App\Http\Controllers\CustomerController::class, 'destroy']
    )->middleware('role:admin');


    //orders
    Route::get('/orders', [OrdersController::class, 'index'])->middleware('permission:list_all_orders|sell_books');
    Route::post('/orders', [OrdersController::class, 'createOrder'])->middleware('permission:sell_books');
    Route::post('/orders/cancel', [OrdersController::class, 'cancelOrder'])->middleware('permission:cancel_orders');


    //statistics
    Route::get('/statistics/monthly-sales', [StatisticsController::class, 'monthlySalesStatistics'])->middleware(
        'permission:view_dashboard'
    );

    Route::get('/statistics/best-sellers', [StatisticsController::class, 'bestSellers'])->middleware(
        'permission:view_dashboard'
    );

    Route::get('/statistics/out-of-stock', [StatisticsController::class, 'lowAndOutofStock'])->middleware(
        'permission:view_dashboard'
    );

    //RABC
    Route::get(
        '/rbac/roles',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'index']
    )->middleware('permission:list_all_rbac');

    Route::post(
        '/rbac/role/create',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'create']
    )->middleware('permission:update_rbac');

    Route::post(
        '/rbac/role/update',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'updatePermissions']
    )->middleware('permission:update_rbac');


    Route::get(
        '/rbac/permissions',
        [\App\Http\Controllers\RolesAndPermissionsController::class, 'permissions']
    )->middleware('permission:list_all_rbac');
});
