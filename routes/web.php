<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CropImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|b tes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('crop-image-upload', [CropImageController::class, 'index']);
Route::post('crop-image-upload', [CropImageController::class, 'uploadCropImage']);
