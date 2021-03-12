<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DataController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\PostTypePostController;
use App\Http\Controllers\FieldController;

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
    Route::get('/posttypes/{post_type}', [PostTypeController::class, 'show']);
    Route::post('/posttypes', [PostTypeController::class, 'store']);
    Route::put('/posttypes/{post_type}', [PostTypeController::class, 'update']);

    Route::get('/posttypes/{post_type}/posts', [PostTypePostController::class, 'index']);

    Route::get('/fields', [FieldController::class, 'index']);
    Route::post('/fields', [FieldController::class, 'store']);
    Route::put('/fields/{field}', [FieldController::class, 'update']);
    Route::delete('/fields/{field}', [FieldController::class, 'destroy']);
});


require __DIR__ . '/auth.php';
