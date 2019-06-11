<?php namespace App\SoMe;

abstract class Facebook {

	public static function fb()
	{
		$config = config('services.facebook');
		$fb = new \Facebook\Facebook([
			'app_id' => $config['client_id'],
			'app_secret' => $config['client_secret'],
			'default_access_token' => session('token')
		]);
		return $fb;
	}

	public static function me()
	{
		$fb = self::fb();
		$request = $fb->get('/me');
		return $request->getGraphUser();
	}

}

