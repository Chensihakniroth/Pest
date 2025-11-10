<?php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
});

Route::get('/test', function () {
    return view('test');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customer Routes
    Route::resource('customers', CustomerController::class);

    // Additional customer routes
    Route::post('/customers/{customer}/maintenance', [CustomerController::class, 'markMaintenance'])->name('customers.markMaintenance');
    Route::post('/customers/{customer}/renew', [CustomerController::class, 'renewContract'])->name('customers.renew');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Add this to web.php - TEMPORARY TEST ROUTE
Route::get('/test-status/{customer}', function($customerId) {
    // Check current status multiple ways
    $customer = \App\Models\Customer::find($customerId);
    $dbStatus = \DB::table('customers')->where('id', $customerId)->value('status');

    return [
        'eloquent_status' => $customer->status,
        'direct_db_status' => $dbStatus,
        'timestamp' => now(),
        'customer_id' => $customerId
    ];
    });

    // Add this temporary route to check for active jobs
    Route::get('/check-jobs', function() {
    return [
        'scheduled_tasks' => \DB::table('jobs')->count(),
        'failed_jobs' => \DB::table('failed_jobs')->count(),
    ];
    });



    // Add this to your web.php routes file
Route::get('/direct-status-test/{customer}/{status}', function($customer, $status) {
    if (!in_array($status, ['active', 'pending'])) {
        return 'Invalid status';
    }

    \Log::info('=== DIRECT STATUS TEST ===');
    \Log::info('Customer ID:', ['id' => $customer]);
    \Log::info('Requested status:', ['status' => $status]);

    // Direct database update
    $result = \DB::table('customers')
        ->where('id', $customer)
        ->update(['status' => $status]);

    \Log::info('Update result:', ['affected_rows' => $result]);

    // Check immediately
    $newStatus = \DB::table('customers')->where('id', $customer)->value('status');
    \Log::info('New status in database:', ['status' => $newStatus]);

    return [
        'update_result' => $result,
        'new_status' => $newStatus,
        'customer_id' => $customer,
        'requested_status' => $status,
        'timestamp' => now()
    ];
});

});
