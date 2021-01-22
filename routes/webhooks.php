<?php

use App\Http\Controllers\Webhooks\HotmartController;
use Illuminate\Support\Facades\Route;

Route::prefix('hotmart')->group(function () {

    // Webhook ETI
    Route::post('/', [HotmartController::class, 'releaseStudentRegistration']);

});
