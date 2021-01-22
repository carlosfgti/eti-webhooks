<?php

use App\Http\Controllers\Webhooks\HotmartController;
use Illuminate\Support\Facades\Route;

Route::prefix('hotmart')
        ->middleware(['hotmart'])
        ->group(function () {

    // Webhook ETI
    Route::post('/', [HotmartController::class, 'newSale']);

});
