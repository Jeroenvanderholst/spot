<?php

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::redirect('/', '/dashboard');

Route::group(['middleware'=> ['auth:sanctum', 'verified']], function () {

    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/products/main', function () { return view('livewire.products.main'); })->name('products.main');
    Route::get('/products/test', function () { return view('livewire.products.test'); })->name('products.test');
    Route::get('/products/texts', function () { return view('livewire.products.texts'); })->name('products.texts');
    Route::get('/products/images', function () { return view('livewire.products.images'); })->name('products.images');

    Route::get('/articles/main', function () { return view('livewire.articles.main'); })->name('articles.main');
    Route::get('/articles/logistics', function () { return view('livewire.articles.logistics'); })->name('articles.logistics');
    Route::get('/articles/prices', function () { return view('livewire.articles.prices'); })->name('articles.prices');

    Route::get('/etim/dynamic-update', function () { return view('livewire.etim.dynamic-update'); })->name('etim/dynamic-update');
    Route::get('admin/etim', function () { return view('admin.etim'); })->name('admin/etim');
    Route::get('/test', function () {return view('livewire.test'); })->name('test');

});

