<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => '/'], function () {
    Route::get('/', [ShortLinkController::class, 'index']);
    Route::post('generate-shorten-link', [ShortLinkController::class, 'store'])->name('generate.shorten.link.post');
    Route::get('{code}', [ShortLinkController::class, 'shortenLink'])->name('shorten.link');
    Route::post('click', [ShortLinkController::class, 'clickLatest'])->name('click.last');
});
