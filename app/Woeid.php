<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Woeid extends Model {

	public $timestamps = false;

	public $fillable = [
		'name',
		'placecode',
		'placename',
		'url',
		'parentid',
		'country',
		'woeid',
		'countrycode'
	];

}



