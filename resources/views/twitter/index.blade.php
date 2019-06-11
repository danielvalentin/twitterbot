@extends('layouts.app')

@section('content')

	<h1>{{ $account->nickname }}</h1>
	@alerts
	<tweets url="{{ route('Ajax:twitter:timeline', ['id' => $id]) }}"></tweets>
@endsection
