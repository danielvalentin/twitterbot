<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Some extends Model
{
	
	public $fillable = [
		'user_id',
		'media',
		'media_id',
		'token',
		'tokenSecret',
		'nickname',
		'name',
		'avatar',
		'followers_count',
		'friends_count',
		'created',
		'statuses_count'
	];

    public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function searches()
	{
		return $this->hasMany('App\Search');
	}

	public function name()
	{
		if($this->media == 'twitter')
		{
			return '@'.$this->nickname;
		}
		if($this->media == 'facebook')
		{
			return $this->nickname ?: $this->name;
		}
	}

}
