<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\models\Product;

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

    $products = Product::all();
    return view('index')->with('products', $products);
});

Route::get('/payment/{id}', [PaymentController::class, "index"])->name("payment.index");
Route::post('/payment', [PaymentController::class, "store"])->name("payment.store");

Route::get('/orderStatus', [OrderController::class, "index"])->name("order.index");
Route::get('/paymentAgain/{idOrder}', [OrderController::class, "paymentAgain"])->name("order.paymentAgain");
Route::get('/getStatus', [OrderController::class, "getStatus"])->name("order.getStatus");
Route::get('/listOrders', [OrderController::class, "listOrders"])->name("order.listOrders");
