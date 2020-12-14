<?php

/**
 * Register Route For Page Controller
 *
 */


use Code95\Page\Controller\PageController;
use Illuminate\Support\Facades\Route;

Route::get('pages/json', [PageController::class, 'getJson'])->name('pages-json');
Route::put('pages/toggle-status/{page}', [PageController::class, 'toggleStatus']);
Route::resource('pages', PageController::class)->except('update');
Route::post('pages/{page}', [PageController::class, 'update'])->name('pages.update');
