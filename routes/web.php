<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PictureController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware('auth:sanctum')
    ->name('api')
    ->group(function() {
        Route::get('comments', [CommentController::class, 'show']);
        Route::post('comment/add', [CommentController::class, 'create']);
        Route::get('comment/{id}/replies', [CommentController::class, 'replies']);
        Route::delete('comment/delete/{id}', [CommentController::class, 'delete']);

        Route::get('picture/{filename}', [PictureController::class, 'get'])->name('.picture');
});

require __DIR__.'/auth.php';

Route::fallback(function() {
    return view('app');
});
