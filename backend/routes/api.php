<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use Illuminate\Http\Request;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/branches', [BranchController::class, 'getBranches']);
    Route::post('/branches', [BranchController::class, 'addBranch']);
    Route::put('/branches/{id}', [BranchController::class, 'updateBranch']);
    Route::delete('/branches/{id}', [BranchController::class, 'deleteBranch']);
});
