<?php

use App\Http\Controllers\HealthRecommendationModuleController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UserAuthController;
use App\admin\Controllers\AdminIndexController;
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

/** Welcome page */
Route::get('/welcome', function () {
    return view('welcome');
});

/** Index page */
Route::get('/', IndexController::class)->name('index');

/** Действия пользователя */
//Route::get('/login', [UserAuthController::class, 'index'])->name('user.login');
Route::post('/user/login', [UserAuthController::class, 'loginUser'])->name('user.login.user');
Route::get('/user/logout', [UserAuthController::class, 'logoutUser'])->name('user.logout');
Route::post('/user/check', [UserAuthController::class, 'checkUser'])->name('user.check.user');
Route::post('/user/registration', [UserAuthController::class, 'registration'])->name('user.registration');
Route::post('/user/check-code', [UserAuthController::class, 'checkCode'])->name('user.check.code');

/** Блок Новости */
Route::get('/news', NewsController::class)->name('news');
Route::get('/news/{url}', [NewsController::class, 'newsSingle'])->name('news.single');

/** Блок Отзывы */
Route::get('/reviews', ReviewsController::class)->name('reviews');

/** Admin Panel */
Route::get('/admin-panel', AdminIndexController::class)->name('admin-panel');
Route::get('/admin-panel/get-news-list', [AdminIndexController::class, 'getNewsList'])->name('admin.news.list');
Route::post('/admin-panel/news-save', [AdminIndexController::class, 'newsSave'])->name('admin.news.save');
Route::post('/admin-panel/news-delete', [AdminIndexController::class, 'newsDelete'])->name('admin.news.delete');
Route::post('/admin-panel/news-update', [AdminIndexController::class, 'newsUpdate'])->name('admin.news.update');

/** Рекомендательный модуль здоровья сотрудника */
Route::get('/health-recommendation-module', HealthRecommendationModuleController::class)->name('health.recommendation.module');
Route::get('/health-recommendation-module/get-order-points', [HealthRecommendationModuleController::class, 'getOrderPointsList'])->name('health.recommendation.list');
Route::get('/health-recommendation-module/get-diagnoses-list', [HealthRecommendationModuleController::class, 'getDiagnosesList'])->name('health.diagnoses.list');
Route::post('/health-recommendation-module/get-recommendations', [HealthRecommendationModuleController::class, 'getRecommendations'])->name('health.recommendation.get.recommendations');

/** Завершающий этап маршрутизации */
Route::get('/{url}', [IndexController::class, 'pageSingle'])->name('index.page.single');
