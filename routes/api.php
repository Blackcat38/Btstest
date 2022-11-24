<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\ApiController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);

    Route::get('/checklist', [ChecklistController::class, 'index']);
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'destroy']);

    Route::get('/checklist/{id}/item', [ChecklistItemController::class, 'index']);
    Route::get('/checklist/{id}/item/{id_items}', [ChecklistItemController::class, 'show']);
    Route::post('/checklist/{id}/item', [ChecklistItemController::class, 'store']);
    Route::delete('/checklist/{id}/item/{id_items}', [ChecklistItemController::class, 'destroy']);
    Route::put('/checklist/{id}/item/rename/{id_items}', [ChecklistItemController::class, 'update']);
});
