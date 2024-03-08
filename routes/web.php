<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\CategoryList;
use App\Http\Livewire\ProductForm;
use App\Http\Livewire\ProductList;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('categories', CategoryList::class)->name('categories.index');
    Route::get('products', ProductList::class)->name('products.index');
    Route::get('product/create', ProductForm::class)->name('product.create');
    Route::get('product/edit/{product}', ProductForm::class)->name('product.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
