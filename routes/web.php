<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NameController;

Route::get('/', [NameController::class, 'index']);
Route::post('/save-name', [NameController::class, 'store'])->name('save.name');
Route::get('/export-json', [NameController::class, 'export'])->name('export.json');
Route::get('/names', [NameController::class, 'index'])->name('names.index');
Route::post('/names', [NameController::class, 'store'])->name('names.store');
