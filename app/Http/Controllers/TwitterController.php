<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Socialite;

use App\Some;
use App\Woeid;

class TwitterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
		session(['secret' => $account->tokenSecret]);
		return redirect()
			->route('Twitter:account', [
				'media_id' => $account->media_id
			]);
	}

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
		return view('twitter.index', [
			'account' => $account,
			'id' => $media_id
		]);
	}

	public function trends(Request $request, $media_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		if(!$account)
		{
			abort(404);
		}
		try
		{
			$location = Woeid::where('country', 'Denmark')->first();
			$trends = \Twitter::getTrendsPlace([
				'id' => $location->woeid,
				'until' => date('Y-m-d', strtotime('-1 week'))
			]);
			$trends = $trends[0];
			$huh = \Carbon\Carbon::createFromTimestamp($trends->as_of)-> format('m-d-Y');
			return view('twitter.trends', [
				'trends' => $trends,
				'time' => $huh
			]);
		}
		catch(\Exception $e)
		{
			var_dump(\Twitter::logs());
			throw $e;
		}
	}

	public function search(Request $request, $media_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		if(!$account)
		{
			abort(404);
		}
		return view('twitter.search', [
			'media_id' => $media_id
		]);
	}

	public function searches(Request $request, $media_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		if(!$account)
		{
			abort(404);
		}
		return view('twitter.searches', [
			'media_id' => $media_id,
			'searches' => $account->searches()->get()
		]);
	}

	public function savesearch(Request $request, $media_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		if(!$account)
		{
			abort(404);
		}
		$query = $request->input('query');
		$da = $request->input('da', false);
		$geocode = $request->input('geocode', false);
		$replies = $request->input('replies', false);
		$retweets = $request->input('retweets', false);
		$title = $request->input('title', false);
		if(!$title)
		{
			$title = mb_substr($query, 0, 190);
		}
		$data = [
			'search' => $query,
			'da' => $da,
			'geocode' => $geocode,
			'replies' => $replies,
			'retweets' => $retweets
		];
		$query = \App\Search::create([
			'some_id' => $account->id,
			'title' => $title,
			'query' => json_encode($data),
		]);
		return redirect()
			->route('Twitter:account:search:display', [
				'media_id' => $media_id,
				'search_id' => $query->id
			])
			->with('success', 'Oprettet');
	}

	public function displaysearch(Request $request, $media_id, $search_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		$search = $account->searches()
			->where('id', '=', $search_id)
			->first();
		if(!$account || !$search)
		{
			abort(404);
		}
		$search->attention = 0;
		$search->save();
		$data = json_decode($search->query);
		return view('twitter.displaysearch', [
			'search' => $search,
			'data' => $data,
			'id' => $search_id,
			'mediaid' => $media_id
		]);
	}

	public function edit(Request $request, $media_id, $search_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		$search = $account->searches()
			->where('id', '=', $search_id)
			->first();
		if(!$account || !$search)
		{
			abort(404);
		}
		$data = json_decode($search->query);
		return view('twitter.editsearch', [
			'search' => $search,
			'data' => $data,
			'searchid' => $search_id,
			'mediaid' => $media_id
		]);
	}

	public function delete(Request $request, $media_id, $search_id)
	{
		$account = \Auth::user()
			->somes()
			->where('media_id', '=', $media_id)
			->first();
		$search = $account->searches()
			->where('id', '=', $search_id)
			->first();
		if(!$account || !$search)
		{
			abort(404);
		}
		$search->delete();
		return redirect()
			->route('Twitter:account:search', ['media_id' => $media_id])
			->with('info', 'Search deleted');
	}

	public function handle_callback(Request $request)
	{
		$user = \Socialite::driver('twitter')->user();
		$token = $request->get('oauth_token');
		if($user && $token);
		{
			$media_id = $user->user['id_str'];
			$existing = \Auth::user()
				->somes()
				->where('media_id', '=', $media_id)
				->first();
			if(!$existing)
			{
				$some = Some::create([
					'user_id' => \Auth::id(),
					'media' => 'twitter',
					'media_id' => $user->user['id_str'],
					'token' => $user->token,
					'tokenSecret' => $user->tokenSecret,
					'nickname' => $user->nickname,
					'name' => $user->name,
					'avatar' => $user->avatar,
					'followers_count' => $user->user['followers_count'],
					'friends_count' => $user->user['friends_count'],
					'created' => $user->user['created_at'],
					'statuses_count' => $user->user['statuses_count']
				]);
				return redirect()
					->route('Some:accounts')
					->with('success', 'Account added.');
			}
			$existing->token = $user->token;
			$existing->tokenSecret = $user->tokenSecret;
			$existing->nickname = $user->nickname;
			$existing->name = $user->name;
			$existing->avatar = $user->avatar;
			$existing->followers_count = $user->user['followers_count'];
			$existing->friends_count = $user->user['friends_count'];
			$existing->statuses_count = $user->user['statuses_count'];
			$existing->save();
			return redirect()
				->route('Twitter:account', [
					'media_id' => $user->user['id_str']
				])
				->with('info', 'Account updated');
		}
	}

    public function add_account()
    {
		return \Socialite::driver('twitter')->redirect();
        return view('twitter.add-account');
    }
}
