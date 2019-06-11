@extends('layouts.app')

@section('content')

	<h1>some.accounts</h1>
	@alerts


	@if(count($accounts) > 0)
		<ul>
			@foreach($accounts as $account)
				<li>
					@if($account->media == 'twitter')
						<a href="{{ route('Twitter:switchaccount', ['media_id' => $account->media_id]) }}">
							<icon type="{{ $account->media }}" /></icon>
							{{ $account->name() }}
						</a>
					@endif
					@if($account->media == 'facebook')
						<a href="{{ route('Facebook:switchaccount', ['media_id' => $account->media_id]) }}">
							<icon type="{{ $account->media }}" /></icon>
							{{ $account->name() }}
						</a>
					@endif
				</li>
			@endforeach
		</ul>
	@else
		<p><em>Du har ikke tilføjet nogle kontoer endnu.</em></p>
	@endif

@endsection
