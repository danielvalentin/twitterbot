<?php namespace App\SoMe;

use GuzzleHttp\Client as guzzle;

class Twitter {

	private static $base = 'https://api.twitter.com/1.1/';

	public static function setTwitterInfo()
	{
		$session = session();
		if($session->has('token') && $session->has('secret'))
		{
			\Twitter::reconfig([
				'token' => $session->get('token'),
				'secret' => $session->get('secret')
			]);
		}
	}

	public static function normalize_tweets($results)
	{
		$tweets = [];
		foreach($results as $tweet)
		{
			$text = '';
			if(property_exists($tweet, 'text'))
			{
				$text = $tweet->text;
			}
			if(property_exists($tweet, 'full_text'))
			{
				$text = $tweet->full_text;
			}

			$text = nl2br($text);
			$text = \Twitter::linkify($text);

			$reply = (bool)$tweet->in_reply_to_status_id;
			if($reply)
			{
				$reply = [
					'to' => $tweet->in_reply_to_screen_name,
					'id' => $tweet->in_reply_to_status_id,
					'url' => 'https://twitter.com/statuses/'.$tweet->in_reply_to_status_id
				];
			}

			$retweet = NULL;
			if(property_exists($tweet, 'retweeted_status') && (bool)$tweet->retweeted_status)
			{
				$retext = '';
				if(property_exists($tweet->retweeted_status, 'text'))
				{
					$retext = $tweet->retweeted_status->text;
				}
				if(property_exists($tweet->retweeted_status, 'full_text'))
				{
					$retext = $tweet->retweeted_status->full_text;
				}
				$retweet = [
					'id' => $tweet->retweeted_status->id,
					'url' => 'https://twitter.com/statuses/'.$tweet->retweeted_status->id,
					'user' => $tweet->retweeted_status->user,
					'full_text' => \Twitter::linkify($retext)
				];
			}

			$tweets[] = [
				'text' => $text,
				'user' => $tweet->user,
				'user_description' => \Twitter::linkify($tweet->user->description),
				'user_since' => \Twitter::ago($tweet->user->created_at),
				'created' => \Carbon\Carbon::parse($tweet->created_at)->format('d-m-Y, H:i'),
				'retweets' => $tweet->retweet_count,
				'favorites' => $tweet->favorite_count,
				'lang' => $tweet->lang,
				'id' => $tweet->id,
				'url' => 'https://twitter.com/statuses/'.$tweet->id,
				'profileurl' => 'https://twitter.com/'.$tweet->user->screen_name,
				'reply' => $reply,
				'retweet' => $retweet,
				'favorited' => $tweet->favorited,
				'retweeted' => $tweet->retweeted
			];
		}
		return $tweets;
	}

	public static function signature($url, $token)
	{
		$nonce = base64_encode(time().'21390297'.'Noget Digitalt');
		$data = [
			'OAuth oauth_consumer_key' => \config('services.twitter.client_id'),
			'oauth_nonce' => $nonce,
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_token' => $token,
			'oauth_version' => '1.0',
		];
		$str = '';
		$str .= 'OAuth oauth_consumer_key='.\config('services.twitter.client_id').'&';
		$str .= 'oauth_nonce='.$nonce.'&';
		$str .= 'oauth_signature_method=HMAC-SHA1&';
		$str .= 'oauth_token='.$token.'&';
		$str .= 'oauth_version=1.0';
		return implode($data, '&');
		return urlencode(implode('&',$data));
	}

	public static function search($q, $token)
	{
		$q = urlencode($q);
		$url = self::$base . 'search/tweets.json';
		
		$request = new guzzle();
		$response = $request->request('GET', $url, [
			'query' => [
				'q' => $q
			],
			'headers' => [
				'Authorization' => [
					'OAuth oauth_consumer_key="'.\config('services.twitter.client_id').'",' .
					'oauth_nonce="'.$nonce.'",' .
					'oauth_signature="",' .
					'oauth_signature_method="HMAC-SHA1",' .
					'oauth_token="'.$token.'",' .
					'oauth_version="1.0",'
				]
			]
		]);
		$code = $response->getStatusCode();
		$reply = $response->getBody();
		return $reply;
	}

}

