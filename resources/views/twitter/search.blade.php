@extends('layouts.app')

@section('content')
	<h1>twitter search</h1>
	<form action="{{ route('Twitter:account:search:save', ['media_id' => $media_id]) }}" method="post">
		@csrf
		<twitter-search><twitter-search>
	</form>
@endsection
