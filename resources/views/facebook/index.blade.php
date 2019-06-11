@extends('layouts.app')

@section('content')
	<h1>{{ $account->name() }}</h1>
	@alerts
@endsection
