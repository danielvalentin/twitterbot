@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col">
			@include('partials.header', ['title' => 'Twitter search: '.$search->title])
		</div>
		<div class="col-1 text-right">
			<a href="{{ route('Twitter:account:search:edit', ['media_id' => $mediaid, 'search_id' => $id]) }}">
				<icon type="cog"></icon>
			</a>
		</div>
	</div>
	<tweets search="{{ $id }}" url="{{ route('Ajax:twitter:search:tweets', ['id' => $id]) }}" deletable />
@endsection
