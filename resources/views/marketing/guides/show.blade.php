@extends('marketing.layout', ['pageTitle' => $guide->title])

@section('content')
    <div class="guide_container">
    	<div class="guide_innerContainer">
    		<article>
    			<header class="mb-xl">
    				<div class="guideTitle text-center fs-3 bold mb-md lh-5">
	    				{{ $guide->title }}
	    			</div>

		    		<div class="text-center fs-1 lh-4 text-gray-6">
		    			{{ $guide->description }}
		    		</div>
    			</header>
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