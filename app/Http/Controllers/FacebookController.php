<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Socialite;

class FacebookController extends Controller
{

	public function index(Request $request, $media_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		if(!$account)
		{
			abort(404);
		}
		$fb = \App\SoMe\Facebook::fb();
		$response = $fb->get('/me/feed');
		dd($response->getBody());
		return view('facebook.index', [
			'account' => $account,
			'id' => $media_id,
		]);
	}

	public function switchaccount(Request $request, $media_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		if(!$account)
		{
			abort(404);
		}
		session(['token' => $account->token]);

		$me = \App\SoMe\Facebook::me();
		if($account->name != $me->getName())
		{
			$account->name = $me->getName();
			$account->save();
		}

		return redirect()
			->route('Facebook:account', [
				'media_id' => $account->media_id
			]);
	}

	public function handle_callback(Request $request)
	{
		$user = \Socialite::driver('facebook')->user();
		if($user);
		{
			$id = $user->id;
			$existing = \Auth::user()
				->somes()
				->where('media_id', '=', $media_id)
				->first();
			if(!$existing)
			{
				$some = Some::create([
					'user_id' => \Auth::id(),
					'media' => 'facebook',
					'media_id' => $user->id,
					'token' => $user->token,
					'tokenSecret' => $request->get('code', ''),
					'nickname' => $user->nickname,
					'name' => $user->name,
					'avatar' => $user->avatar,
				]);
				return redirect()
					->route('Some:accounts')
					->with('success', 'Account added.');
			}
			$existing->token = $user->token;
			$existing->nickname = $user->nickname;
			$existing->name = $user->name;
			$existing->avatar = $user->avatar;
			$existing->save();
			return redirect()
				->route('Facebook:account', [
					'media_id' => $user->id
				])
				->with('info', 'Account updated');
		}
	}
    public function add_account()
    {
		return \Socialite::driver('facebook')->redirect();
    }
}
