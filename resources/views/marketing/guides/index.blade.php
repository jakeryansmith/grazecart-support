@extends('marketing.layout', ['pageTitle' => 'GrazeCart Guides'])

@section('page_header')
	<div class="pageHeader_container">
		<div class="pageHeader_innerContainer flex align-items-m">
			<div class="flex-item fs-6 mr-lg text-primary-3">
				<i class="fas fa-user-circle"></i>
			</div>
			<div class="flex-item">
				<div class="fs-5 bold lh-2">GrazeCart Guides</div>
				<div class="fs-normal text-primary-9 lh-3 ml-xs">Step by step guides for becoming a GrazeCart expert</div>
			</div>	
		</div>
	</div>	
@stop

@section('content')
	<div class="guides_container">	
		<div class="guides_innerContainer">
			@foreach($guides as $guide)
				<a href="{{ url('/guides/'.$guide->slug) }}">
					<div class="align-items-t">
						<div class="flex-item">
							<div class="text-gray fs-2 bold mb-xs lh-2">
								{{ $guide->title }}!
							</div>
							<div class="fs-1 text-gray-5 mb-md lh-3">
								{{ $guide->description }}
							</div>
							<img src="{!! $guide->cover_photo !!}">
						</div>
					</div>
				</a>
			@endforeach
		</div>
	</div>
@stop