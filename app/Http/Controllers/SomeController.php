<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SomeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function accounts(Request $request)
	{
		$accounts = \Auth::user()
			->somes()
			->get();
		return view('some.accounts', [
			'accounts' => $accounts
		]);
	}

}
