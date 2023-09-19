<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories', CategoryController::class)->only('index', 'show');
Route::apiResource('categories', CategoryController::class)->only('update', 'destroy', 'store')
    ->middleware(['auth:sanctum', 'admin']);

Route::name('news.')->group(function () {
    Route::get('news', [ArticleController::class, 'index']);
    Route::get('news/{article}', [ArticleController::class, 'show']);
    Route::get('news/category/{category}', [ArticleController::class, 'getByCategory']);
    Route::post('news', [ArticleController::class, 'store'])->middleware(['auth:sanctum', 'admin']);
    Route::put('news/{article}', [ArticleController::class, 'update'])->middleware(['auth:sanctum', 'admin']);
    Route::delete('news/{article}', [ArticleController::class, 'destroy'])->middleware(['auth:sanctum', 'admin']);
});

Route::apiResource('comments', CommentController::class)->only('index', 'show');
Route::apiResource('comments', CommentController::class)->only('store')
    ->middleware('auth:sanctum');
Route::apiResource('comments', CommentController::class)->only('update', 'destroy')
    ->middleware(['auth:sanctum', 'commentOwnerOrAdmin']);

Route::apiResource('roles', RoleController::class);

Route::apiResource('users', UserController::class)->only('index', 'store', 'show');
Route::apiResource('users', UserController::class)->only('update')
    ->middleware(['auth:sanctum', 'ownUserOrAdmin']);
Route::apiResource('users', UserController::class)->only('destroy')
    ->middleware(['auth:sanctum', 'admin']);
Route::put('assign_roles/{user}', [UserController::class, 'assignRolesToUser'])
    ->middleware(['auth:sanctum', 'admin']);

Route::post('login', [LoginController::class,'login']);

Route::get('images/{filename}', function ($filename) {
    $path = storage_path('app/public/img/' . $filename);

    if (!file_exists($path)) {
        return response()->json(['message' => 'Imagen no encontrada'], 404);
    }

    return response()->file($path);
});
