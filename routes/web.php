<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\IntegratorController;
use App\Http\Livewire\Staff;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name("home")->middleware("auth");//Index Page
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name("login")->middleware("guest");//login Page
    Route::get('/register', 'register')->name("register")->middleware("guest");//register Page
    Route::post('/check', 'check')->name("check")->middleware("guest");//check the user Page
    Route::post('/create', 'create')->name("create")->middleware("guest");//create user Page
    Route::get('/logout', 'logout')->name("logout")->middleware("auth");//logout
});




Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name("profile")->middleware("auth");//Index Page
    Route::put('/edit-user-data', 'editUserData')->name("editUserData")->middleware("auth");//editUserData Page
    Route::get('/password', 'password')->name("password")->middleware("auth");//password Page
    Route::put('/change-password', 'changePassword')->name("changePassword")->middleware("auth");//changePassword Page
});



//livewire Route
Route::get('/all-Staff', Staff::class)->name("staff")->middleware("auth");

Route::controller(RoleController::class)->group(function () {
    Route::get('/role-table', 'index')->name("roleTable")->middleware("auth");//role-table Page
    Route::post('/add-role', 'addRole')->name("addRole")->middleware("auth");//add-role Page
    Route::get('/edit-role/{id}', 'editRole')->name("editRole")->middleware("auth");//edit-role Page
    Route::put('/update-role/{id}', 'updateRole')->name("updateRole")->middleware("auth");//update-role Page
    Route::delete('/delete-role/{id}', 'deleteRole')->name("deleteRole")->middleware("auth");//delete-role Page
});

Route::controller(StaffController::class)->group(function () {
    Route::get('/staff-table', 'index')->name("staffTable")->middleware("auth");//staff-table Page
    Route::post('/add-staff', 'addStaff')->name("addStaff")->middleware("auth");//add-staff Page
    Route::delete('/delete-staff/{id}', 'deleteStaff')->name("deleteStaff")->middleware("auth");//delete-staff Page
});


Route::controller(CategoryController::class)->group(function () {
    Route::get('/category-table', 'index')->name("CategoryTable")->middleware("auth");//Category-table Page
    Route::post('/add-category', 'addCategory')->name("addCategory")->middleware("auth");//add-category Page
    Route::get('/edit-category/{id}', 'editCategory')->name("editCategory")->middleware("auth");//edit-category Page
    Route::put('/update-category/{id}', 'updateCategory')->name("updateCategory")->middleware("auth");//update-category Page
    Route::delete('/delete-category/{id}', 'deleteCategory')->name("deleteCategory")->middleware("auth");//delete-category Page
});


Route::controller(IntegratorController::class)->group(function () {
    Route::get('/integrator-table', 'index')->name("IntegratorTable")->middleware("auth");//Integrator-table Page
    Route::get('/show-details/{id}', 'showDetails')->name("showDetails")->middleware("auth");//show Details Page
    Route::post('/add-integrator', 'addIntegrator')->name("addIntegrator")->middleware("auth");//add-Integrator Page
    Route::get('/edit-integrator/{id}', 'editIntegrator')->name("editIntegrator")->middleware("auth");//edit-Integrator Page
    Route::put('/update-integrator/{id}', 'updateIntegrator')->name("updateIntegrator")->middleware("auth");//update-Integrator Page
    Route::delete('/delete-integrator/{id}', 'deleteIntegrator')->name("deleteIntegrator")->middleware("auth");//delete-Integrator Page
});



Route::controller(PurchasesController::class)->group(function () {
    Route::post('/pay/{id}', 'pay')->name("pay")->middleware("auth");//pay Page
    Route::get('/edit-pay/{id}', 'editPay')->name("editPay")->middleware("auth");//pay Page
    Route::put('/update-pay/{id}', 'updatePay')->name("updatePay")->middleware("auth");//pay Page
    Route::delete('/delete-shop/{id}', 'deleteShop')->name("deleteShop")->middleware("auth");//delete Pay
    Route::post('/get-payment/{id}', 'getPayment')->name("getPayment")->middleware("auth");//getPayment Pay
    Route::get('/edit-payment/{paymentId}', 'editpayment')->name("editpayment")->middleware("auth");//payment Page
    Route::put('/update-payment/{paymentId}', 'updatePayment')->name("updatePayment")->middleware("auth");//payment Page
});



