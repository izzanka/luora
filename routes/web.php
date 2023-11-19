<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Home;
use App\Livewire\User\Answer\AnswerIndex;
use App\Livewire\User\Profile\ProfileIndex;
use App\Livewire\User\Question\QuestionIndex;
use App\Livewire\User\Stat;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/stats', [StatController::class, 'index'])->name('stats.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/answers', AnswerIndex::class)->name('answer.index');
    Route::get('/{question:title_slug}', QuestionIndex::class)->name('question.index');
    Route::get('/profile/{user:username_slug}', ProfileIndex::class)->name('profile.index');
});
