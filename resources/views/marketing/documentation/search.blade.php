@extends('marketing.layout', ['pageTitle' => 'Search Results'])

@section('content')
	<div class="searchResults_container">
		<div class="searchResults_innerContainer">
			<div class="fs-3">Search for <span class="bold">{{ request()->get('q') }}</span></div>
			Documentation {{ str_plural('result', $articleResults->count()) }}
			<ul class="searchResults_list">
			@foreach($articleResults as $articleResult)
			<li class="mb-sm">
				<a href="{{ url($articleResult->url) }}">
					<div class="bold mb-sm">{{ $articleResult->title }}</div>
					<div class="text-gray-4 fs-1">{{ $articleResult->description }}</div>
				</a>
			</li>	
			@endforeach
			@foreach($faqResults as $faqResult)
			<li class="mb-sm">
				<a href="{{ url($faqResult->url ?? '#') }}">
					<div class="bold mb-sm">{{ $faqResult->title }}</div>
					<div class="text-gray-4 fs-1">{{ $faqResult->description }}</div>
				</a>
			</li>	
			@endforeach
			</ul>
		</div>
	</div>
@stop