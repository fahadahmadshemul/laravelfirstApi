<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware'=> 'auth:sanctum'], function(){
    //get user from api
    Route::get('/users/{id?}', [UserApiController::class, 'showUser']);
    //add data by api
    Route::post('add-user', [UserApiController::class, 'addUser']);
    //add multiple user
    Route::post('add-multiple-user', [UserApiController::class, 'addMultipleUser']);
    //update user
    Route::put('update-user/{id}', [UserApiController::class, 'update_user']);

    //patch for single data update
    Route::patch('update-single-column/{id}', [UserApiController::class, 'single_column_update']);

    //delete single user
    Route::delete('delete-single-user/{id}', [UserApiController::class, 'delete_singleUser']);

    //delete user by column info
    Route::delete('delete-by-json', [UserApiController::class, 'deleteByJson']);

    //multiple delete by parameter
    Route::delete('muliple-delete-param/{ids}', [UserApiController::class, 'multipleDeleteParam']);

    //multple delete by json
    Route::delete('multiple-delete-json', [UserApiController::class, 'multipleDeleteJson']);
});
Route::post('login', [UserApiController::class, 'login']);