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
    use App\Http\Controllers\InvoiceController;
    use App\Http\Controllers\ReportsController;
    use App\Http\Controllers\TransactionsController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\FilesController;

    // Authentification
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Auth::routes();

    // Accueil
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

    // Profil utilisateur
    Route::get('/profile', function () {
        return view('users.profile');
    })->middleware('auth')->name('profile');

    // Tableau de bord et fournisseurs, avec Middleware Auth dans un groupe
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('suppliers', SupplierController::class);

        // Utilisateurs
        Route::resource('users', UserController::class);

        // Clients
        Route::resource('clients', ClientController::class);
        Route::get('/search-clients', [ClientController::class, 'search'])->name('clients.search');

        // Produits
        Route::resource('products', ProductController::class);
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

        // Catégories
        Route::resource('categories', CategoryController::class);

        // Commandes
        Route::resource('orders', OrderController::class);

        // Factures
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/{id}/download-pdf', [InvoiceController::class, 'downloadPDF'])->name('invoices.downloadPDF');

        // Rapports
        Route::resource('reports', ReportsController::class);

        // Transactions
        Route::resource('transactions', TransactionsController::class);

        // Gestion des stocks
        Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');

        // Paramètres
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        // Facturation
        Route::get('/billing', [BillingController::class, 'index'])->name('billing');
    });

    // Déconnexion
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Route pour afficher le formulaire de connexion
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

    // Route pour soumettre le formulaire de connexion
    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');

    Route::middleware(['auth'])->group(function () {
        // Affichage du profil de l'utilisateur
        Route::get('/profil', [UserProfileController::class, 'index'])->name('profil.index');

        // Mise à jour du profil de l'utilisateur
        Route::put('/profil/update', [UserProfileController::class, 'update'])->name('profil.update');

        // Suppression du compte de l'utilisateur
        Route::delete('/profil/delete', [UserProfileController::class, 'delete'])->name('profil.delete');
    });


    // Afficher le formulaire de demande de réinitialisation de mot de passe
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    // Envoyer l'e-mail de réinitialisation de mot de passe
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Afficher le formulaire de réinitialisation de mot de passe
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    // Réinitialiser le mot de passe
    Route::get('/passwords/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('passwords.reset');

    // Route pour afficher le formulaire de demande de réinitialisation de mot de passe
    Route::get('/password/reset', function () {
        return view('auth.passwords.password-request');
    })->name('password.request');


