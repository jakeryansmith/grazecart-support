@extends('marketing.layout', ['pageTitle' => $guide->title])

@section('content')
    <div class="guide_container">
    	<div class="guide_innerContainer">
    		<article>
    			<header class="mb-xl">
    				<div class="guideTitle fs-3 bold mb-md lh-2">
	    				{{ $guide->title }}
	    			</div>

		    		<div class="guideDescription fs-1 lh-3 text-gray-6">
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