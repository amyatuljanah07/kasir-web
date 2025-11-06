<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Cashier\CashierReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CustomerTransactionController;



Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth','role:pegawai|admin'])->group(function(){
  // Halaman POS Kasir
  Route::get('/pos', [PosController::class,'index'])->name('pos.index');
  
  // Scan barcode
  Route::post('/pos/scan', [PosController::class,'scanBarcode'])->name('pos.scan');
  
  // Proses transaksi / sales
  Route::post('/pos/sales', [SaleController::class,'store'])->name('pos.sales');
  
  // Checkout transaksi (alias untuk backward compatibility)
  Route::post('/pos/checkout', [PosController::class,'checkout'])->name('pos.checkout');
  
  // Register customer baru oleh kasir
  Route::post('/pos/register-customer', [PosController::class,'registerCustomer'])->name('pos.register-customer');
  
  // Cetak struk PDF
  Route::get('/pos/receipt/{sale}', [SaleController::class,'receipt'])->name('pos.receipt');
});

// Cashier Reports (khusus pegawai)
Route::middleware(['auth','role:pegawai'])->prefix('cashier')->name('cashier.')->group(function(){
  Route::get('/reports', [CashierReportController::class, 'index'])->name('reports');
  Route::get('/reports/export', [CashierReportController::class, 'exportPdf'])->name('reports.export');
  
  // Order Verification (Virtual Card Orders)
  Route::get('/verification', [\App\Http\Controllers\Cashier\OrderVerificationController::class, 'index'])->name('verification');
  Route::post('/verification/{order}/verify', [\App\Http\Controllers\Cashier\OrderVerificationController::class, 'verify'])->name('verification.verify');
  Route::post('/verification/{order}/complete', [\App\Http\Controllers\Cashier\OrderVerificationController::class, 'complete'])->name('verification.complete');
  Route::get('/verification/{order}/print', [\App\Http\Controllers\Cashier\OrderVerificationController::class, 'printReceipt'])->name('verification.print');
});

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
  // Dashboard
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  
  // Manajemen Produk
  Route::resource('products', AdminProduct::class);
  
  // Manajemen Varian Produk
  Route::post('products/{product}/variants', [VariantController::class, 'store'])->name('variants.store');
  Route::put('variants/{variant}', [VariantController::class, 'update'])->name('variants.update');
  Route::delete('variants/{variant}', [VariantController::class, 'destroy'])->name('variants.destroy');
  
  // Laporan
  Route::get('reports', [ReportController::class,'index'])->name('reports');
  Route::get('reports/export', [ReportController::class,'exportPdf'])->name('reports.export');
  Route::get('users/{user}/orders', [ReportController::class,'userOrders'])->name('user.orders');
  
  // Manajemen User
  Route::resource('users', UserManagementController::class);
  Route::patch('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
  
  // Top-Up Verification
  Route::get('topup', [\App\Http\Controllers\Admin\TopUpController::class, 'index'])->name('topup.index');
  Route::post('topup/{id}/approve', [\App\Http\Controllers\Admin\TopUpController::class, 'approve'])->name('topup.approve');
  Route::post('topup/{id}/reject', [\App\Http\Controllers\Admin\TopUpController::class, 'reject'])->name('topup.reject');
});

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

// Customer Transaction History (POS Transactions Only)
Route::middleware(['auth','role:customer'])->group(function(){
  Route::get('/customer/transactions', [CustomerTransactionController::class, 'index'])->name('customer.transactions');
  Route::get('/customer/transactions/{id}', [CustomerTransactionController::class, 'show'])->name('customer.transactions.show');
  Route::get('/customer/transactions/{id}/download', [CustomerTransactionController::class, 'downloadReceipt'])->name('customer.transactions.download');
});

// Customer Virtual Card & Self-Service Shopping
Route::middleware(['auth','role:customer'])->prefix('customer')->name('customer.')->group(function(){
  // Dashboard
  Route::get('/dashboard', function() {
    return redirect()->route('customer.virtual-card');
  })->name('dashboard');
  
  // Virtual Card
  Route::get('/virtual-card', [\App\Http\Controllers\Customer\VirtualCardController::class, 'index'])->name('virtual-card');
  Route::post('/virtual-card/change-pin', [\App\Http\Controllers\Customer\VirtualCardController::class, 'changePin'])->name('virtual-card.change-pin');
  
  // Shopping
  Route::get('/shop', [\App\Http\Controllers\Customer\ShopController::class, 'index'])->name('shop');
  Route::post('/shop/add-to-cart', [\App\Http\Controllers\Customer\ShopController::class, 'addToCart'])->name('shop.add-to-cart');
  Route::post('/shop/checkout', [\App\Http\Controllers\Customer\ShopController::class, 'checkout'])->name('shop.checkout');
  
  // Orders
  Route::get('/orders', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders');
  Route::get('/orders/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
  Route::get('/orders/{order}/receipt', [\App\Http\Controllers\Customer\OrderController::class, 'receipt'])->name('orders.receipt');
  
  // Balance Management
  Route::get('/balance', [\App\Http\Controllers\Customer\BalanceController::class, 'index'])->name('balance');
  Route::get('/balance/topup', [\App\Http\Controllers\Customer\BalanceController::class, 'topUp'])->name('balance.topup');
  Route::post('/balance/topup', [\App\Http\Controllers\Customer\BalanceController::class, 'processTopUp'])->name('balance.process-topup');
  Route::get('/balance/confirmation/{id}', [\App\Http\Controllers\Customer\BalanceController::class, 'confirmation'])->name('balance.confirmation');
  Route::post('/balance/approve/{id}', [\App\Http\Controllers\Customer\BalanceController::class, 'approve'])->name('balance.approve');
  
  // Profile
  Route::get('/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('profile');
  Route::put('/profile', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
  Route::put('/profile/password', [\App\Http\Controllers\Customer\ProfileController::class, 'updatePassword'])->name('profile.password');
  Route::delete('/profile/photo', [\App\Http\Controllers\Customer\ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
  
  // Membership
  Route::get('/membership', [\App\Http\Controllers\Customer\MembershipController::class, 'index'])->name('membership');
  Route::post('/membership/join', [\App\Http\Controllers\Customer\MembershipController::class, 'join'])->name('membership.join');
  Route::get('/membership/welcome', [\App\Http\Controllers\Customer\MembershipController::class, 'welcome'])->name('membership.welcome');
  Route::get('/membership/exclusive', [\App\Http\Controllers\Customer\MembershipController::class, 'exclusive'])->name('membership.exclusive');
  
  // Leaderboard
  Route::get('/leaderboard', [\App\Http\Controllers\Customer\LeaderboardController::class, 'index'])->name('leaderboard');
  Route::post('/leaderboard/claim-voucher/{voucher}', [\App\Http\Controllers\Customer\LeaderboardController::class, 'claimVoucher'])->name('leaderboard.claim-voucher');
});

