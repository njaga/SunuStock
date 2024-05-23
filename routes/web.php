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

// Route pour rediriger l'URL racine vers le tableau de bord
Route::get('/', function () {
    return redirect('/dashboard');
})->name('login');

// Routes d'authentification
Auth::routes();

// Routes accessibles uniquement aux utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    // Page d'accueil
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profil utilisateur
    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');

    // Tableau de bord et autres ressources
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
    
    // Route pour la suppression des produits
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Edition et mise à jour des fournisseurs
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');

    // Routes pour le profil utilisateur
    Route::get('/profil', [UserProfileController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [UserProfileController::class, 'update'])->name('profil.update');
    Route::delete('/profil/delete', [UserProfileController::class, 'delete'])->name('profil.delete');

    // Informations sur l'entreprise
    Route::get('/entreprise/edit', [EntrepriseController::class, 'edit'])->name('entreprise.edit');
    Route::post('/entreprise/update', [EntrepriseController::class, 'update'])->name('entreprise.update');

    // Servir les fichiers de logo
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

// Route pour la déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes pour la réinitialisation du mot de passe
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
