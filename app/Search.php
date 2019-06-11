<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
		'some_id',
		'title',
		'query',
		'lastid',
		'attention'
	];

	public function some()
	{
		return $this->belongsTo('App\Some');
	}

	public function tweets()
	{
		return $this->hasMany('App\Tweet');
	}

	public function run()
	{
		$data = json_decode($this->query);
		$some = $this->some();

		try
		{
			\Twitter::reconfig([
				'token' => $this->some->token,
				'secret' => $this->some->tokenSecret
			]);
			$term = $data->search . ' AND -filter:retweets';
			if((bool)$data->replies)
			{
				$term .= ' AND -filter:replies';
			}
			$vars = [
				'q' => $term,
				'tweet_mode' => 'extended',
				'lang' => 'da',
				'count' => 50
			];
			if((bool)$data->geocode)
			{
				$vars['geocode'] = '56.195154,10.503436,300km';
			}
			if($this->lastid)
			{
				$vars['since_id'] = $this->lastid;
			}
			$results = \Twitter::getSearch($vars);
			$tweets = [];
			$lastid = null;
			if(count($results->statuses) > 0)
			{
				$this->attention = 1;
				mail('daniel@nogetdigitalt.dk', 'twitter.nogetdigitalt.dk found new tweets', 'Search: "'.$this->title.'" found new tweets. See: '.route('Twitter:account:search:display', ['media_id' => $some->media_id, 'search_id' => $this->id]));
			}
			foreach($results->statuses as $tweet)
			{
				\App\Tweet::create([
					'some_id' => $this->some_id,
					'search_id' => $this->id,
					'tweet_id' => $tweet->id,
					'dump' => json_encode($tweet)
				]);
				if(!$lastid)
				{
					$lastid = $tweet->id;
				}
				else
				{
					if($tweet->id > $lastid)
					{
						$lastid = $tweet->id;
					}
				}
			}
			if($lastid)
			{
				$this->lastid = $lastid;
			}
			$this->save();
		}
		catch(\RuntimeException $e)
		{
			\Applog::warning('RuntimeException while running Twitter search',[
				'id' => $this->id,
				'code' => $e->getCode(),
				'msg' => $e->getMessage()
			]);
		}
		catch(\Exception $e)
		{
			\Applog::error('Exception while running Twitter search',[
				'id' => $this->id,
				'code' => $e->getCode(),
				'msg' => $e->getMessage()
			]);
		}
	}

	public function getSearch()
	{
		$data = json_decode($this->query);
		return $data->search;
	}

	public function delete()
	{
		$tweets = $this->tweets()->delete();
		return parent::delete();
	}

}
