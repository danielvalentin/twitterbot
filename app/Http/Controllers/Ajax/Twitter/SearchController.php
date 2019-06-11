<?php

namespace App\Http\Controllers\Ajax\Twitter;

use Illuminate\Http\Request;

class SearchController
{

	public function found(Request $request, int $search)
	{
		$search = \App\Search::find($search);
		if(!$search)
		{
			abort(404);
		}
		$results = $search->tweets()
			->orderBy('id', 'Desc')
			->get()
			->pluck('dump')
			->all();
		$tweets = [];
		foreach($results as $result)
		{
			$tweets[] = json_decode($result);
		}
		return response()
			->json([
				\App\SoMe\Twitter::normalize_tweets($tweets)
			]);
	}

    public function search(Request $request)
    {
		\App\SoMe\Twitter::setTwitterInfo();
		$term = $request->input('term');
		$retweets = $request->input('retweets', true);
		if($retweets)
		{
			$term = $term . ' AND -filter:retweets';
		}
		$replies = $request->input('replies');
		if($replies)
		{
			$term .= ' AND -filter:replies';
		}
		$vars = [
			'q' => $term,
			'tweet_mode' => 'extended',
			'count' => 50
		];
		$geocode = $request->input('geocode');
		if($geocode)
		{
			$vars['geocode'] = '56.195154,10.503436,300km';
		}
		$da = $request->input('da');
		if($da)
		{
			$vars['lang'] = 'da';
		}
		$results = \Twitter::getSearch($vars);
		return response()
			->json([
				'statuses' => \App\SoMe\Twitter::normalize_tweets($results->statuses),
				'term' => $term
			]);
    }

}
