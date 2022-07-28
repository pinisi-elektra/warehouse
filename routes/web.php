<?php

use App\Exports\ProductTransactionExport;
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
    return redirect('/admin');
});

Route::get('/v1/export/product-transactions', \App\Http\Controllers\ExportProductTransactionController::class)->name('export.product-transactions');

require __DIR__.'/auth.php';
