<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('books',[BookController::class,'index']);
Route::post('book/add',[BookController::class,'store']);
Route::get('books/{id}/show',[BookController::class,'show']);
Route::get('books/title', [BookController::class, 'search']);
Route::get('/books/author', [BookController::class, 'Author']);
Route::put('books/{id}/update',[BookController::class,'update']);
Route::delete('books/{id}/delete',[BookController::class,'delete']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
