<?php

use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('incidents')->middleware(['magic.token'])->group(function () {
    Route::post('/', [IncidentController::class, 'store']);
    Route::get('/reports/{department}', [IncidentReportController::class, 'index']);
});
