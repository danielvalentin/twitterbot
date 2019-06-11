<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applog extends Model
{
    protected $fillable = [
		'type',
		'message',
		'data'
	];
}
