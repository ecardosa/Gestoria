<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ProfilePanelController;
use App\Http\Controllers\CompaniesPanelController;


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

Route::get('/', function () {
    return Redirect::route('login');
});

Route::get('/admin-panel', [AdminPanelController::class, 'index'])->name('admin-panel');
Route::get('/admin-panel/get-all-users', [AdminPanelController::class, 'getAllUsers'])->name('admin-panel.get-all-users');
Route::delete('/admin-panel/delete/{id}', [AdminPanelController::class, 'deleteUser'])->name('admin-panel.delete');
Route::patch('/admin-panel/update/{id}', [AdminPanelController::class, 'updateUser'])->name('admin-panel.update');
Route::get('/admin-panel/get-profiles', [AdminPanelController::class, 'getProfiles'])->name('admin-panel.get-profiles');
Route::post('/admin-panel/add-user', [AdminPanelController::class, 'AddUser'])->name('admin-panel.add-user');

Route::get('/profile-panel', [ProfilePanelController::class, 'index'])->name('profile-panel');
Route::get('/profile-panel/get-profile', [ProfilePanelController::class, 'getProfile'])->name('profile-panel.get-profile');
Route::post('/profile-panel/add-profile', [ProfilePanelController::class, 'addProfile'])->name('profile-panel.add-profile');
Route::delete('/profile-panel/delete-profile/{id}', [ProfilePanelController::class, 'deleteProfile'])->name('profile-panel.delete-profile');

Route::get('/companies-panel', [CompaniesPanelController::class, 'index'])->name('companies-panel');
Route::get('/companies-panel/get-companies', [CompaniesPanelController::class, 'getCompanies'])->name('companies-panel.get-companies');
Route::get('/companies-panel/get-profiles', [CompaniesPanelController::class, 'getProfiles'])->name('companies-panel.get-profiles');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
