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

// Pages
Route::get('/', 'PageController@index')
	->name('pages:home');

// SoMe accounts
Route::get('/accounts', 'SomeController@accounts')
	->name('Some:accounts');

// Twitter
Route::get('/accounts/twitter/{media_id}', 'TwitterController@switchaccount')
	->name('Twitter:switchaccount');
Route::get('/account/twitter/{media_id}', 'TwitterController@index')
	->name('Twitter:account');
Route::get('/account/twitter/{media_id}/trends', 'TwitterController@trends')
	->name('Twitter:account:trends');
Route::get('/account/twitter/{media_id}/search', 'TwitterController@search')
	->name('Twitter:account:search');
Route::get('/account/twitter/{media_id}/searches', 'TwitterController@searches')
	->name('Twitter:account:searches');
Route::post('/account/twitter/{media_id}/search/save', 'TwitterController@savesearch')
	->name('Twitter:account:search:save');
Route::get('/account/twitter/{media_id}/search/{search_id}', 'TwitterController@displaysearch')
	->name('Twitter:account:search:display');

Route::get('/account/twitter/{media_id}/search/{search_id}/edit', 'TwitterController@edit')
	->name('Twitter:account:search:edit');
Route::get('/account/twitter/{media_id}/search/{search_id}/delete', 'TwitterController@delete')
	->name('Twitter:account:search:delete');

Route::get('/twitter/add-account', 'TwitterController@add_account')
	->name('Twitter:account:add');
Route::get('/twitter/callback', 'TwitterController@handle_callback')
	->name('Twitter:account:callback');

// Facebook
Route::get('/facebook/add-account', 'FacebookController@add_account')
	->name('Facebook:account:add');
Route::get('/facebook/callback', 'FacebookController@handle_callback')
	->name('Facebook:account:callback');

Route::get('/accounts/facebook/{media_id}', 'FacebookController@switchaccount')
	->name('Facebook:switchaccount');
Route::get('/account/facebook/{media_id}', 'FacebookController@index')
	->name('Facebook:account');

// Auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
