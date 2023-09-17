<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Home;
use App\Livewire\User\Profile\Index;
use App\Livewire\User\Answer\Index as AnswerIndex;
use App\Livewire\User\Question\Show;
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

Route::middleware('auth')->group(function(){
    Route::get('/', Home::class)->name('home');
    Route::get('/answers', AnswerIndex::class)->name('answer.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/{question:title_slug}', Show::class)->name('question.show');
    Route::get('/profile/{user:username_slug}', Index::class)->name('profile.index');

});

