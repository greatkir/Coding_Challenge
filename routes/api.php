<?php

declare(strict_types=1);

use App\Http\Controllers\CompanyCreateController;
use App\Http\Controllers\InvoiceCreateController;
use App\Http\Controllers\InvoiceMarkPaidController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/company', CompanyCreateController::class);
Route::post('/invoice', InvoiceCreateController::class);
Route::patch('/invoice/{id}/markPaid', InvoiceMarkPaidController::class);
