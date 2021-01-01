<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the prescribers
|
*/

use App\Http\Controllers\Administrators\Prescribers\PrescriberController;

Route::get('prescribers', [
    PrescriberController::class,
    'index',
])->name('prescribers')->middleware('permission:crud_prescribers');
Route::post('prescribers/load', [
    PrescriberController::class,
    'load',
])->name('prescribers/load')->middleware('permission:crud_prescribers');

Route::group([
    'middleware' => 'permission:crud_prescribers',
    'prefix' => 'prescribers',
    'as' => 'prescribers/',
], function () {
    Route::get('show/{id}', [PrescriberController::class, 'show'])->name('show')->where('id', '[1-9][0-9]*');

    Route::get('create', [PrescriberController::class, 'create'])->name('create');

    Route::post('store', [PrescriberController::class, 'store'])->name('store');

    Route::put('update/{id}', [PrescriberController::class, 'update'])->name('update')->where('id', '[1-9][0-9]*');

    Route::get('edit/{id}', [PrescriberController::class, 'edit'])->name('edit')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        PrescriberController::class,
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::patch('restore/{id}', [PrescriberController::class, 'restore'])->name('restore')->where('id', '[1-9][0-9]*');
});