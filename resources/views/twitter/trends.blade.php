@extends('layouts.app')

@section('content')

	<h1>Trends as of {{ $trends->as_of }} in {{ $trends->locations[0]->name }}</h1>
	@alerts
	<ul id="trendslist">
		@foreach($trends->trends as $trend)
			<li>
				<a href="{{ $trend->url }}">{{ $trend->name }}</a>
			</li>
		@endforeach
	</ul>
@endsection
