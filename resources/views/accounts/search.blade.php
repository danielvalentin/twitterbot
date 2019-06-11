@extends('layouts.app')

@section('content')

	<h1>Search {{ ucfirst($account->media) }}</h1>

	<search-params media="{{ $media }}" route="{{ route('Some:account:search', ['media_id' => $media]) }}"></search-params>

@endsection

