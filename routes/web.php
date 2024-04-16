<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\EntrepriseController;
use Illuminate\Support\Facades\Storage; 

// Authentication Routes
Route::get('/', function () {
    return view('auth.login');
})->name('login');
Auth::routes();

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // User Profile
    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');

    // Dashboard and Resources
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('users', UserController::class);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::resource('clients', ClientController::class);
    Route::get('/search-clients', [ClientController::class, 'search'])->name('clients.search');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{id}/download-pdf', [InvoiceController::class, 'downloadPDF'])->name('invoices.downloadPDF');
    Route::resource('reports', ReportsController::class);
    Route::resource('transactions', TransactionsController::class);
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/billing', [BillingController::class, 'index'])->name('billing');

    // User profile routes
    Route::get('/profil', [UserProfileController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [UserProfileController::class, 'update'])->name('profil.update');
    Route::delete('/profil/delete', [UserProfileController::class, 'delete'])->name('profil.delete');

    // Enterprise information
    Route::get('/entreprise/edit', [EntrepriseController::class, 'edit'])->name('entreprise.edit');
    Route::post('/entreprise/update', [EntrepriseController::class, 'update'])->name('entreprise.update');

    // Serve logo files
    Route::get('/logos/{filename}', function ($filename) {
        $path = storage_path('app/public/logos/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        return response($file, 200)->header("Content-Type", $type);
    })->name('logo.file');

});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
