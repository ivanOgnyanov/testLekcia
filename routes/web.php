<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExportMembersController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Слайд 8 - данни от контролера към изглед
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// Слайдове 17-19, 27 - Request в контролер, зареждане на изглед
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

// Слайдове 20-22 - input(), integer(), boolean(), string(), has(), filled(), масиви
Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');

// Слайдове 30-34 - $request->validate(), @error, old()
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

// Слайд 14 и 52 - допълнителният маршрут е ПРЕДИ Route::resource
Route::get('/members/export', ExportMembersController::class)->name('members.export');

// Слайдове 36-51 - FormRequest и ресурсен контролер
Route::resource('members', MemberController::class);
