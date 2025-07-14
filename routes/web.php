<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Login Routes (GET + POST)
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Authenticated Admin Routes
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/songs', [AdminController::class, 'songs'])->name('admin.uploads');
Route::post('/songs/{id}/approve', [AdminController::class, 'approveSong'])->name('admin.songs.approve');
Route::post('/songs/{id}/reject', [AdminController::class, 'rejectSong'])->name('admin.songs.reject');
});

// Normal User Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/releases', [UserController::class, 'release'])->name('user.releases');
});

//Settings Routes
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

//Payment Routes
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::post('/withdrawal/save', [PaymentController::class, 'saveWithdrawal'])->name('withdrawal.save');


// Auth scaffolding (Laravel Breeze / Jetstream / Fortify etc.)
require __DIR__.'/auth.php';