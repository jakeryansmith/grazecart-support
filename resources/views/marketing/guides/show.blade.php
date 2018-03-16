@extends('marketing.layout', ['pageTitle' => $guide->title, 'layout' => 'main_container--guide'])

@section('page_header')
	<div class="pageHeader_container">
		<div class="pageHeader_innerContainer flex align-items-m">
			<div class="flex-item-fill text-center">
				<div class="fs-4 bold lh-2 mb-sm">{{ $guide->title }}</div>
				<div class="fs-normal text-primary-9 lh-3 ml-xs">{{ $guide->description }}</div>
			</div>	
		</div>
	</div>	
@stop

@section('content')
    <div class="guide_container">
    	<div class="guide_innerContainer">
    		<article>
    			<div class="guide_content">
					@if($guide->draft && auth()->check())
						{!! $guide->draft_body !!}
					@else
						{!! $guide->body !!}
					@endif	
				</div>
    		</article>
		</div>	
	</div>
@stop