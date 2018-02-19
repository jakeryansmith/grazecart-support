@extends('marketing.layout', ['pageTitle' => 'Search Results'])

@section('content')
	<div class="searchResults_container">
		<div class="searchResults_innerContainer">
			<div class="fs-3 lh-2 mb-lg">{{ $count }} {{ str_plural('result', $count ) }} for <span class="bold">{{ request()->get('q') }}</span></div>
			<ul class="searchResults_list">
			@foreach($articleResults as $articleResult)
			<li class="mb-sm">
				<a href="{{ url($articleResult->url) }}">
					<div class="bold mb-sm lh-3">{{ $articleResult->title }}</div>
					<div class="text-gray-4 fs-1 lh-3">{{ $articleResult->description }}</div>
				</a>
			</li>	
			@endforeach
			@foreach($faqResults as $faqResult)
			<li class="mb-sm">
				<a href="{{ url($faqResult->url ?? '#') }}">
					<div class="bold mb-sm lh-3">{{ $faqResult->title }}</div>
					<div class="text-gray-4 fs-1 lh-3">{{ $faqResult->description }}</div>
				</a>
			</li>	
			@endforeach
			</ul>
		</div>
	</div>
@stop