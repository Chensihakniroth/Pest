<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmployeeDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Flights Routes
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/search', [FlightController::class, 'searchForm'])->name('flights.searchForm');
Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Routes
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/boarding-pass', [BookingController::class, 'boardingPass'])->name('bookings.boardingPass');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings.index');

    // Payment Routes
    Route::get('/payments/{booking}/process', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{booking}/process', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
});

// Admin/Employee Routes
Route::middleware(['auth', 'role:admin,employee'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('admin.dashboard');
});


