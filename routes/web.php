<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminMusicController;
use App\Http\Controllers\RoyaltiesController;
use App\Http\Controllers\PayoutController;

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionPlanController;

// Public Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Authenticated Admin Routes
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/approve/{id}', [AdminController::class, 'approveMusic'])->name('approve.music');
    Route::post('/reject/{id}', [AdminController::class, 'rejectMusic'])->name('reject.music');

    // Users
    Route::prefix('users')->name('labels.')->group(function () {
        Route::get('/', [AdminController::class, 'labels'])->name('all');
        Route::get('/artists', [AdminController::class, 'artists'])->name('artists');
        Route::get('/pending', [AdminController::class, 'pendingApprovals'])->name('pending');
        Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');
         
    });

    

    // Music Releases
    Route::prefix('music')->name('releases.')->group(function () {
        Route::get('/all', [AdminMusicController::class, 'index'])->name('all');
       

        Route::get('/pending', [AdminMusicController::class, 'pending'])->name('pending');
        Route::get('/approved', [AdminMusicController::class, 'status'])->name('approved')->defaults('status', 'approved');
        Route::get('/rejected', [AdminMusicController::class, 'status'])->name('reject')->defaults('status', 'rejected');
        Route::get('/metadata/{id}', [AdminMusicController::class, 'metadata'])->name('metadata');
        Route::post('/metadata/{id}', [AdminMusicController::class, 'updateMetadata'])->name('metadata.update');
    });

    // Pricing and Subscriptions
    Route::prefix('pricing')->name('pricing.')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, 'plans'])->name('plans');           // View all plans
        Route::get('/create', [SubscriptionPlanController::class, 'create'])->name('create'); // Show create form
        Route::post('/store', [SubscriptionPlanController::class, 'store'])->name('store');   // Save new plan

        Route::get('/{plan}/edit', [SubscriptionPlanController::class, 'editPlan'])->name('edit'); // Show edit form
        Route::put('/{plan}', [SubscriptionPlanController::class, 'updatePlan'])->name('update');

        Route::delete('/{plan}', [SubscriptionPlanController::class, 'deletePlan'])->name('destroy'); // Delete plan
    });


    // Royalties
   
Route::prefix('royalties')->name('royalties.')->group(function () {
    // Main reports dashboard
    Route::get('/reports', [RoyaltiesController::class, 'reports'])->name('reports');

    // Specific report pages
    Route::get('/reports/royalties', [RoyaltiesController::class, 'royaltiesReport'])->name('reports.royalties');
    Route::get('/reports/streams', [RoyaltiesController::class, 'streamsReport'])->name('reports.streams'); // ✅ FIXED
    Route::get('/reports/earnings', [RoyaltiesController::class, 'earningsReport'])->name('reports.earnings'); // ✅ FIXED

    // Upload endpoint
    Route::post('/reports/upload', [RoyaltiesController::class, 'uploadReport'])->name('reports.upload');

    // Payouts section
    Route::get('/payouts', [RoyaltiesController::class, 'payouts'])->name('payouts');
});



    // Payouts
    Route::prefix('payouts')->name('payouts.')->group(function () {
        Route::get('/requests', [PayoutController::class, 'requests'])->name('requests');  // admin.payouts.requests
        Route::post('/approve/{id}', [PayoutController::class, 'approve'])->name('approve'); // added payout approval
        Route::post('/reject/{id}', [PayoutController::class, 'reject'])->name('rejected');    // added payout rejection
    });

    // Payments
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/history', [PaymentController::class, 'history'])->name('history');   // admin.payments.history
        Route::get('/pricing', [PaymentController::class, 'pricing'])->name('pricing');   // admin.payments.pricing
    });

    // Analytics & Reports
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/streaming', [AnalyticsController::class, 'streamingStats'])->name('streaming'); // admin.analytics.streaming
        Route::get('/revenue', [AnalyticsController::class, 'revenueReports'])->name('revenue');    // admin.analytics.revenue
        Route::get('/growth', [AnalyticsController::class, 'userGrowth'])->name('growth');  // admin.analytics.usergrowth
        Route::get('/export', [AnalyticsController::class, 'export'])->name('export');              // admin.analytics.export
    });

    // Support
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/tickets', [SupportController::class, 'tickets'])->name('tickets');          // admin.support.tickets
        Route::get('/kb', [SupportController::class, 'knowledgeBase'])->name('kb');              // admin.support.kb
        Route::get('/feedback', [SupportController::class, 'feedback'])->name('feedback');      // admin.support.feedback
        Route::get('/faq', [SupportController::class, 'faq'])->name('faq');                      // admin.support.faq
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [SettingsController::class, 'general'])->name('general');           // admin.settings.general
        Route::get('/payment', [SettingsController::class, 'paymentGateway'])->name('payment');   // admin.settings.payment
        Route::get('/integrations', [SettingsController::class, 'integrations'])->name('integrations'); // admin.settings.integrations
        Route::get('/security', [SettingsController::class, 'security'])->name('security');       // admin.settings.security
        Route::get('/site_content', [SettingsController::class, 'siteContent'])->name('site_content'); // admin.settings.site_content
    });

    // Logout
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('logout');});

// Normal User Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/releases', [UserController::class, 'release'])->name('user.releases');
});

// User Settings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
    Route::post('/settings', [UserController::class, 'updateSettings'])->name('user.settings.update');
});

// Authenticated User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authenticated Artist Management
Route::middleware(['auth'])->group(function () {
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    Route::get('/artists/create', [ArtistController::class, 'create'])->name('artists.create');
    Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
    Route::get('/artists/{artist}/edit', [ArtistController::class, 'edit'])->name('artists.edit');
    Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update');
});

// Payment Routes
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::post('/withdrawal/save', [PaymentController::class, 'saveWithdrawal'])->name('withdrawal.save');

// Auth scaffolding (Laravel Breeze / Jetstream / Fortify etc.)
require __DIR__ . '/auth.php';
