@extends('marketing.layout')

@section('page_header')
	<div class="pageHeader_container">
		<div class="pageHeader_innerContainer flex align-items-m">
			<div class="flex-item mr-lg text-primary-3">
				<i class="fas fa-info-circle"></i>
			</div>
			<div class="flex-item">
				<div class="fs-5 bold mb-sm">Documentation</div>
				<div class="fs-normal text-primary-9 lh-4 ml-xs">Learn how GrazeCart works and what all it can do</div>
			</div>	
		</div>	
	</div>	
@stop

@section('content')
	<div class="topics_container">	
		<div class="topics_innerContainer">
			@foreach($topics as $topic)
				<a href="{{ url('/docs/topic/'.$topic->slug) }}" class="topic_card pa-lg shadow-soft">
					<div class="flex align-items-t">
						<div class="flex-item fs-2 mr-sm text-primary-7">
							{!! $topic->icon !!}
						</div>
						<div class="flex-item">
							<div class="text-gray fs-2 bold mb-sm">
								{{ $topic->title }}
							</div>
							<div class="lh-3 fs-1 text-gray-5">
								{{ $topic->description }}
							</div>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	</div>
@stop