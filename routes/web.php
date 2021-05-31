<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DataController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\PostTypePostController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\DataValueController;
use App\Http\Controllers\DataListController;
use App\Models\Post;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/datas', [DataController::class, 'index']);
    Route::get('/datas/create', [DataController::class, 'create']);
    Route::post('/datas', [DataController::class, 'store']);
    Route::get('/datas/{data}', [DataController::class, 'show']);
    Route::put('/datas/{data}', [DataController::class, 'update']);
    Route::delete('/datas/{data}', [DataController::class, 'destroy']);

    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::get('/posts/create', [PostController::class, 'create']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    

    Route::get('/posttypes', [PostTypeController::class, 'index'])->name('posttypes');
    Route::get('/posttypes/create', [PostTypeController::class, 'create']);
    Route::get('/posttypes/{post_type}/edit', [PostTypeController::class, 'edit']);
    Route::post('/posttypes', [PostTypeController::class, 'store']);
    Route::put('/posttypes/{post_type}', [PostTypeController::class, 'update']);
    Route::delete('/posttypes/{post_type}', [PostTypeController::class, 'destroy']);


    Route::get('/posttypes/{post_type}/posts', [PostTypePostController::class, 'index']);

    Route::get('/fields', [FieldController::class, 'index']);
    Route::post('/fields', [FieldController::class, 'store']);
    Route::get('/fields/{field}/edit', [FieldController::class, 'edit']);
    Route::put('/fields/{field}', [FieldController::class, 'update']);
    Route::delete('/fields/{field}', [FieldController::class, 'destroy']);

    Route::get('/authorizations', [AuthorizationController::class, 'index'])->name('authorizations');
    Route::get('/authorizations/create', [AuthorizationController::class, 'create']);
    Route::get('/authorizations/{authorization}/edit', [AuthorizationController::class, 'edit']);
    Route::post('/authorizations', [AuthorizationController::class, 'store']);
    Route::put('/authorizations/{authorization}', [AuthorizationController::class, 'update']);
    Route::delete('/authorizations/{authorization}', [AuthorizationController::class, 'destroy']);


    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create']);
    Route::get('/users/{user}/edit', [UserController::class, 'edit']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);


    Route::get('/dataList/{dataList}/edit', [DataListController::class, 'edit']);
    Route::put('/dataList/{dataList}', [DataListController::class, 'update']);

    Route::post('/dataValue', [DataValueController::class, 'store']);

});


require __DIR__ . '/auth.php';
