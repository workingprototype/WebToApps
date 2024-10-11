<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NameController;

Route::get('/', [NameController::class, 'index']); // This route now works
Route::post('/save-name', [NameController::class, 'store'])->name('save.name');
Route::get('/export-json', [NameController::class, 'export'])->name('export.json');
Route::post('/names/store', [NameController::class, 'store'])->name('names.store');
Route::post('/names/exportJson', [NameController::class, 'exportJson'])->name('names.exportJson');
