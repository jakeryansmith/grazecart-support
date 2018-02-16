@extends('marketing.layout', ['pageTitle' => 'GrazeCart FAQ'])

@section('page_header')
	<div class="pageHeader_container pageHeader_container--gears">
		<div class="pageHeader_innerContainer flex align-items-m">
			<div class="flex-item fs-6 mr-lg text-primary-3">
				<i class="far fa-question-circle"></i>
			</div>
			<div class="flex-item">
				<div class="fs-5 bold mb-sm">FAQ</div>
				<div class="fs-normal text-primary-9">Answers to our most-popular questions</div>
			</div>	
		</div>	
	</div>	
@stop

@section('content')
	<div class="faq_container">
		<div class="faq_innerContainer">
			<div class="faq_categoriesContainer">
			@foreach($faqs as $key => $faqItems)
				<div class="faq_categoriesContainerItem">
					<div class="fs-normal bold ls-1 uppercase mb-md">
						{{ config("faqs.categories.{$key}.title") }}
					</div>
					<ul class="text-gray-8">
					@foreach($faqItems as $faq)
						<li class="mb-md">
							<a href="/faqs/{{ $faq->slug }}" class="fs-1 light lh-3">{{ $faq->title }}</a>
						</li>
					@endforeach	
					</ul>
				</div>	
			@endforeach
			</div>
		</div>
	</div>
@stop