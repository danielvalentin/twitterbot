<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
		'some_id',
		'search_id',
		'tweet_id',
		'dump'
	];

	public $timestamps = false;

	public function search()
	{
		return $this->belongsTo('App\Search');
	}

	public function some()
	{
		return $this->belongsTo('App\Some');
	}

}
