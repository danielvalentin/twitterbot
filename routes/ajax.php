<?php

Route::post('/ajax/twitter/search', 'Twitter\SearchController@search')
	->name('Ajax:twitter:search');

Route::get('/ajax/twitter/follow/{userid}', 'Twitter\ActionsController@follow')
	->name('Ajax:twitter:follow');
Route::get('/ajax/twitter/unfollow/{userid}', 'Twitter\ActionsController@unfollow')
	->name('Ajax:twitter:unfollow');

Route::get('/ajax/twitter/timeline/{id}', 'Twitter\ActionsController@timeline')
	->name('Ajax:twitter:timeline');

Route::get('/ajax/twitter/tweet/delete/{searchid}/{tweetid}', 'Twitter\ActionsController@delete')
	->name('Ajax:twitter:tweet:delete');

Route::get('/ajax/twitter/tweet/favorite/{tweetid}', 'Twitter\ActionsController@favorite')
	->name('Ajax:twitter:tweet:favorite');
Route::get('/ajax/twitter/tweet/unfavorite/{tweetid}', 'Twitter\ActionsController@unfavorite')
	->name('Ajax:twitter:tweet:unfavorite');

Route::get('/ajax/twitter/tweet/retweet/{tweetid}', 'Twitter\ActionsController@retweet')
	->name('Ajax:twitter:tweet:retweet');
Route::post('/ajax/twitter/tweet/reply/{tweetid}', 'Twitter\ActionsController@reply')
	->name('Ajax:twitter:tweet:reply');

Route::get('/ajax/twitter/search/{id}', 'Twitter\SearchController@found')
	->name('Ajax:twitter:search:tweets');
