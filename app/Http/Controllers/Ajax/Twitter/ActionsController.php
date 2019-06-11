<?php

namespace App\Http\Controllers\Ajax\Twitter;

use Illuminate\Http\Request;

class ActionsController
{

    public function follow(Request $request, $userid)
    {
		\App\SoMe\Twitter::setTwitterinfo();
		$result = \Twitter::postFollow([
			'user_id' => $userid
		]);
		return response()
			->json([
				'result' => $result
			]);
    }

    public function unfollow(Request $request, $userid)
    {
		\App\SoMe\Twitter::setTwitterinfo();
		$result = \Twitter::postUnFollow([
			'user_id' => $userid
		]);
		return response()
			->json([
				'result' => $result
			]);
    }

    public function delete(Request $request, $searchid, $tweetid)
    {
		$search = \App\Search::find($searchid);
		if(!$search)
		{
			throw new \Exception('Search: '.$searchid.' - Not found.');
		}
		$tweet = $search->tweets()
			->where('tweet_id', $tweetid)
			->first();
		if(!$tweet)
		{
			throw new \Exception('Tweet: '.$tweetid.' - not found!');
		}
		$tweet->delete();
		return response()
			->json([
				'status' => 'ok',
				'message' => 'Tweet deleted'
			]);
    }

	public function timeline(Request $request, $id)
	{
		try
		{
			\App\SoMe\Twitter::setTwitterinfo();
			$tweets = \Twitter::getHomeTimeline([
				'exclude_replies' => 1,
				'count' => 50,
				'tweet_mode' => 'extended'
			]);
			return response()
				->json([
					\App\SoMe\Twitter::normalize_tweets($tweets)
				]);
		}
		catch(\RunTimeException $e)
		{
			return response()
				->json([
					'error' => true,
					'type' => 'RunTimeException',
					'code' => $e->getCode(),
					'message' => $e->getMessage()
				]);
		}
	}

	public function favorite(Request $request, $tweetid)
	{
		try
		{
			\App\SoMe\Twitter::setTwitterinfo();
			$tweet = \Twitter::postFavorite([
				'id' => $tweetid,
			]);
			return response()
				->json([
					\App\SoMe\Twitter::normalize_tweets([$tweet])
				]);
		}
		catch(\RunTimeException $e)
		{
			return response()
				->json([
					'error' => true,
					'type' => 'RunTimeException',
					'code' => $e->getCode(),
					'message' => $e->getMessage()
				]);
		}
	}

	public function unfavorite(Request $request, $tweetid)
	{
		try
		{
			\App\SoMe\Twitter::setTwitterinfo();
			$tweet = \Twitter::destroyFavorite([
				'id' => $tweetid,
			]);
			return response()
				->json([
					\App\SoMe\Twitter::normalize_tweets([$tweet])
				]);
		}
		catch(\RunTimeException $e)
		{
			return response()
				->json([
					'error' => true,
					'type' => 'RunTimeException',
					'code' => $e->getCode(),
					'message' => $e->getMessage()
				]);
		}
	}

	public function retweet(Request $request, $tweetid)
	{
		try
		{
			\App\SoMe\Twitter::setTwitterinfo();
			$tweet = \Twitter::postRt($tweetid);
			return response()
				->json([
					\App\SoMe\Twitter::normalize_tweets([$tweet])
				]);
		}
		catch(\RunTimeException $e)
		{
			return response()
				->json([
					'error' => true,
					'type' => 'RunTimeException',
					'code' => $e->getCode(),
					'message' => $e->getMessage()
				]);
		}
	}

	public function reply(Request $request, $tweetid)
	{
		try
		{
			\App\SoMe\Twitter::setTwitterinfo();
			$tweet = \Twitter::postTweet([
				'status' => $request->input('status'),
				'in_reply_to_status_id' => $tweetid
			]);
			return response()
				->json([
					\App\SoMe\Twitter::normalize_tweets([$tweet])
				]);
		}
		catch(\RunTimeException $e)
		{
			return response()
				->json([
					'error' => true,
					'type' => 'RunTimeException',
					'code' => $e->getCode(),
					'message' => $e->getMessage()
				]);
		}
	}

}
