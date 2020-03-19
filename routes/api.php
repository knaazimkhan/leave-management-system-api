<?php

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

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



Route::post('/register', 'API\AuthController@register');

Route::post('/login', 'API\AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('/logout', 'API\AuthController@logout');
    Route::post('/user', 'API\UserController@index');
    Route::post('user/leave', 'API\LeaveController@store');
});

Route::prefix('admin')->middleware(['auth.role:admin'])->group(function () {
    Route::get('/users', 'API\AdminController@index');
    Route::post('/approve', 'API\AdminController@approve');
    Route::post('/reject', 'API\AdminController@reject');
});



// Route::middleware('jwt.auth')->get('me', 'API\AuthController@me');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/users/{user}', function(User $user) {
//     // dd($id);
//     return new UserResource($user);
// });

// Route::get('/users', function() {
//     $user = User::where('id', '<>', 1)->with(['balance', 'apply'])->get();
//     return new UserCollection($user);
// });