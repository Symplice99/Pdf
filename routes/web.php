<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view-pdf/{filename}', [PDFController::class, 'viewPDF']);

Route::get('/pdf-view/{filename}', function ($filename) {
    return view('pdf-view', ['filename' => $filename]);
});

Route::get('/pdf-preview/{filename}', function ($filename) {
    return view('pdf-preview', ['filename' => $filename]); // Passez la variable à la vue pdf-preview
});
