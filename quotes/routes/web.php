<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ConceptsTypesController;
use App\Http\Controllers\ConceptsController;
use App\Http\Controllers\ConceptsRegistersController;
use App\Http\Controllers\QuotasController;
use App\Http\Controllers\QuotasHistoryController;
use App\Http\Controllers\ConceptRegisterHistoryController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\NotActiveController;



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


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'notActive', 'verified'])->name('dashboard');

Route::middleware('admin')->group(function () {
    Route::resource('users', UsersController::class);
    Route::resource('profiles', ProfilesController::class);
});


Route::middleware(['auth', 'notActive'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('companies', CompaniesController::class);
    Route::delete('/companies/{id}/delete-concept-register/{idConceptRegister}', [CompaniesController::class, 'destroyConceptRegister'])->name('companies.delete-concept-register');
    Route::post('/companies/{id}/add-concept-register', [CompaniesController::class, 'addConceptRegister'])->name('companies.add-concept-register');
    Route::resource('concepts-types', ConceptsTypesController::class);
    Route::resource('concepts', ConceptsController::class);
    Route::resource('concepts-registers', ConceptsRegistersController::class);
    Route::resource('quotas', QuotasController::class);
    Route::resource('quotas-history', QuotasHistoryController::class);
    Route::resource('concepts-registers-history', ConceptRegisterHistoryController::class);
    Route::get('/quotas/{id}/pdf', [QuotasController::class, 'pdf'])->name('quotas.pdf');
    Route::post('/concepts-registers/add-existent', [ConceptRegisterController::class, 'addExistent'])->name('concepts-registers.add-existent');
    Route::post('/concepts-registers/existent', [ConceptsRegistersController::class, 'storeExistent'])->name('concepts-registers.storeExistent');

});


Route::get('/not-active', [NotActiveController::class, 'index'])->name('not-active')->middleware('auth');

Route::get('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);

require __DIR__.'/auth.php';
