<?php

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

use Illuminate\Http\Request;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function()
{
    Route::get('/', 'HomeController@getHome')->name('root');


    //Authentication
    Route::get('/login', 'Auth\LoginController@getLogin')->name('login');
    Route::post('/login', 'Auth\LoginController@postLogin');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    //SOCIAL
    Route::get('/redirect/{provider}', 'Auth\SocialController@redirect');
    Route::get('/callback/{provider}', 'Auth\SocialController@callback');

    // Registration Routes...
    Route::get('/signup', 'Auth\RegisterController@getSignup')->name('signup');
    Route::post('/signup', 'Auth\RegisterController@postSignup');

    // Password Reset Routes...
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    //only authorized users can access these routes

    Route::get('/lesson/{lesson_id}', 'Auth\HomeController@getViewLesson')->name('viewLesson');

    
});



Route::get('/category/{category_slug}', 'SearchController@getCategorySearch');
Route::get('/tags/{tag}', 'SearchController@getTagSearch');
Route::get('/search', 'SearchController@getDealsSearch');
Route::post('/search', 'SearchController@getDealsSearch');

Route::get('/deal/{deal_id}', 'DealController@getDeal');
Route::get('/deal-get/{deal_id}', 'DealController@getDealBuy');

Route::get('/featured-deals/{weight}', 'DealController@getFeaturedDeals');

Route::get('/c/{category_slug}/{s?}', 'SearchController@getDealsSearchJSON');

//ADMIN
Route::get('/admin/manage/business', 'BusinessController@index')->middleware('can:business-manage');
Route::get('/admin/business/{business}/edit', 'BusinessController@edit')->middleware('can:business-manage');
Route::post('/admin/business/store', 'BusinessController@store')->middleware('can:business-manage');

Route::get('/admin/manage/deals', 'AdminController@getManageDeals')->middleware('can:deals-manage');

// EMAIL
Route::get('/email/user_buy_deal', 'HomeController@getEmailUserByDeal');
Route::get('/email/business_buy_deal', 'HomeController@getEmailBusinessByDeal');
