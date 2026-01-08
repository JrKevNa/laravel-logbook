<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Dashboard;
use App\Livewire\Logbook;
use App\Livewire\Profile;
use App\Livewire\ToDoList;
use App\Livewire\Users;
use App\Livewire\Projects;
use App\Livewire\DetailProject;
use App\Livewire\DailyReport;
use App\Livewire\UserReport;
use App\Http\Controllers\Auth\GoogleController;
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
    return redirect()->route('dashboard');
});

Route::get('/login', Login::class)
    ->name('login');

Route::get('/register', Register::class)
    ->name('register');

Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);

Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/logbook', Logbook::class)
        ->name('logbook');

    Route::get('/profile', Profile::class)
        ->name('profile');

    Route::get('/to-do-list', ToDoList::class)
        ->name('to-do-list');

    Route::get('/users', Users::class)
        ->middleware('isAdmin')
        ->name('users');

    Route::get('/projects', Projects::class)
        ->name('projects');

    Route::get('/projects/{id}', DetailProject::class)
        ->name('detail-project');

    Route::get('/daily-report', [DailyReport::class, 'export'])
        ->name('daily-report');

    Route::get('/user-report', UserReport::class)
        ->name('user-report');
});