<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingGoodsController;
use App\Http\Controllers\OutcomingGoodsController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DetailsController;

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


// Route for Home 
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Detail of Goods
Route::get('/details-goods/{productName}', [DetailsController::class, 'index'])->name('details.goods');


// Route for Incoming Goods
Route::resource('incomingGoods', IncomingGoodsController::class);
Route::get('/incoming-goods', [IncomingGoodsController::class, 'index'])->name('incomingGoods.index');
Route::get('/incoming-goods/{id}/edit', [IncomingGoodsController::class, 'edit'])->name('incomingGoods.edit');
Route::delete('/incoming-goods/{id}', [IncomingGoodsController::class, 'destroy'])->name('incomingGoods.destroy');
Route::get('incoming-goods/add', [IncomingGoodsController::class, 'add'])->name('incomingGoods.add');
Route::post('/incoming-goods/store', [IncomingGoodsController::class, 'store'])->name('incomingGoods.store');

// Route for Outcoming Goods
Route::resource('outcomingGoods', OutcomingGoodsController::class);
Route::get('/outcoming-goods', [OutcomingGoodsController::class, 'index'])->name('outcomingGoods.index');
Route::get('/outcoming-goods/{id}/edit', [OutcomingGoodsController::class, 'edit'])->name('outcomingGoods.edit');
Route::delete('/outcoming-goods/{id}', [OutcomingGoodsController::class, 'destroy'])->name('outcomingGoods.destroy');
Route::get('outcoming-goods/add', [OutcomingGoodsController::class, 'add'])->name('outcomingGoods.add');
Route::post('/outcoming-goods/store', [OutcomingGoodsController::class, 'store'])->name('outcomingGoods.store');
Route::post('/get-product-stock', [OutcomingGoodsController::class, 'getProductStock'])->name('getProductStock');
Route::put('outcoming-goods/{id}', [OutcomingGoodsController::class, 'update'])->name('outcomingGoods.update');

// Route For Warehouses
Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
Route::resource('warehouse', WarehouseController::class)->except(['create', 'show']);
Route::get('/warehouse/add', [WarehouseController::class, 'add'])->name('warehouse.add');
Route::post('/warehouse/store', [WarehouseController::class, 'store'])->name('warehouse.store');





