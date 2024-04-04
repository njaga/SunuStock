<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
USE App\Http\Controllers\DashboardController;

// Authentification
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

// Accueil
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Profil utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [UserProfileController::class, 'delete'])->name('profile.delete');
});

// Tableau de bord et fournisseurs
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('suppliers', SupplierController::class);
});

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Autres fonctionnalités de gestion
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('products', ProductController::class);
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/stock', [StockController::class, 'index'])->name('stock');
    Route::get('/billing', [BillingController::class, 'index'])->name('billing');
    Route::resource('orders', OrderController::class);
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::resource('invoices', InvoicesController::class);
    Route::resource('reports', ReportsController::class);
    Route::resource('transactions', TransactionsController::class);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/search-clients', [ClientController::class, 'search'])->name('clients.search');
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::resource('categories', CategoryController::class);

    Route::get('/invoices', 'App\Http\Controllers\InvoicesController@index')->name('invoices.index');

    Route::get('/path', 'App\Http\Controllers\FilesController@methodName');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');



});

