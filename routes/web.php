<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceControlller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\TokenVerifyMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication ajux API
Route::post('/user-register', [UserController::class, 'userRegistration']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::post('/sendotp', [UserController::class, 'sendOTPCode']);
Route::post('/otp-varify', [UserController::class, 'OTPVerification']);

Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/reset-profile', [UserController::class, 'userProfile'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/profile-update', [UserController::class, 'userProfileUpdate'])->middleware([TokenVerifyMiddleware::class]);

Route::get('/logout', [UserController::class, 'userLogout']);



// Page Routes
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/userProfile', [UserController::class, 'ProfilePage'])->middleware([TokenVerifyMiddleware::class]);

// Category page Route
Route::get('/categories', [CategoryController::class, 'categoryPage'])->middleware([TokenVerifyMiddleware::class]);
// Product page Route
Route::get('/productPage', [ProductController::class, 'productPage'])->middleware([TokenVerifyMiddleware::class]);
// Customer Page Route
Route::get('/customerPage', [CustomerController::class, 'customerPageShow'])->middleware([TokenVerifyMiddleware::class]);
// Invoice Page
Route::get('/invoicePage', [InvoiceControlller::class, 'invoicePageDisplay'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/salePage', [InvoiceControlller::class, 'salePageInformationShow'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/reportPage', [ReportController::class, 'reportPageShow'])->middleware([TokenVerifyMiddleware::class]);



// Category API
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-create', [CategoryController::class, 'categoryCreate'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-by-id', [CategoryController::class, 'categoryById'])->middleware([TokenVerifyMiddleware::class]);


// Product API
Route::post('/product-create', [ProductController::class, 'productCreate'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-update', [ProductController::class, 'productUpdate'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-delete', [ProductController::class, 'productDelete'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/product-list', [ProductController::class, 'productList'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-by-id', [ProductController::class, 'productById'])->middleware([TokenVerifyMiddleware::class]);


// Customer API
Route::get('/customer-list', [CustomerController::class, 'customerListDisplay'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-create', [CustomerController::class, 'customerCreation'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-update', [CustomerController::class, 'customerUpdating'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-delete', [CustomerController::class, 'customerDeleting'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-by-id', [CustomerController::class, 'showCustomerById'])->middleware([TokenVerifyMiddleware::class]);


// Invoice API
Route::post('/invoice-create', [InvoiceControlller::class, 'invoiceCreation'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/invoice-select', [InvoiceControlller::class, 'invoiceSelection'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/invoice-detail', [InvoiceControlller::class, 'invoiceDetailFetch'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/invoice-delete', [InvoiceControlller::class, 'invoiceDeleting'])->middleware([TokenVerifyMiddleware::class]);

// Summery API
Route::get('/summery', [DashboardController::class, 'summeryReport'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/sales-report/{FormDate}/{ToDate}', [ReportController::class, 'salesReportGenerate'])->middleware([TokenVerifyMiddleware::class]);



