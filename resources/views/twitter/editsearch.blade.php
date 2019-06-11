@extends('layouts.app')

@section('content')
	@include('partials.header', ['title' => 'Edit search: '.$search->title])
	<p>
		<a href="{{ route('Twitter:account:search:delete', ['media_id' => $mediaid, 'search_id' => $searchid]) }}" class="btn btn-danger">Delete</a>
	</p>
@endsection
