<?php

use Motwreen\Consumer\Http\Controllers\CallbackController;
use Motwreen\Consumer\Http\Controllers\RedirectController;

Route::group(['middleware'=>'web'],function () {

    Route::get(config('consumer.routes.redirect'), [RedirectController::class, 'redirect'])->name('consumer.redirect');

    Route::get(config('consumer.routes.callback'), [CallbackController::class, 'callback'])->name('consumer.callback');
});
