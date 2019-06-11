@extends('layouts.app')

@section('content')
	<h1>twitter searches</h1>
	@if($searches->count() > 0)
		<ul>
			@foreach($searches as $search)
				<li>
					<a href="{{ route('Twitter:account:search:display', ['media_id' => $media_id, 'search_id' => $search->id]) }}">
						{{ $search->title }} ({{ $search->tweets->count() }})
					</a>
					@if((bool)$search->attention)
						<icon class="text-success" type="commentdots"></icon>
					@endif
				</li>
			@endforeach
		<ul>
	@else
		<p>
			<em>You have no searches yet! <a href="{{ route('Twitter:account:search', ['media_id' => $media_id]) }}">Create one</a></em>
		</p>
	@endif
@endsection
