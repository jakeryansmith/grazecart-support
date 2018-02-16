@extends('marketing.layout', ['pageTitle' => $faq->title])

@section('content')
    <div class="faq_answerContainer">
    	<div class="faq_answerTitle text-center fs-3 bold mb-lg lh-5">{{ $faq->title }}</div>
		<div class="faq_answerInnerContainer">
			<div class="faq_answerBody lh-5 fs-normal">{!! $faq->body !!}</div>
		</div>
	</div>
	<hr>
	<div class="faq_container">
		<div class="faq_innerContainer pt-xl">
			<div class="faq_categoriesContainer">
			@foreach($faqs as $key => $faqItems)
				<div class="faq_categoriesContainerItem">
					<div class="fs-normal bold ls-1 uppercase mb-md">
						{{ config("faqs.categories.{$key}.title") }}
					</div>
					<ul class="text-gray-8">
					@foreach($faqItems as $faqItem)
						<li class="mb-md">
							<a href="/faqs/{{ $faqItem->slug }}" class="fs-1 light lh-3">{{ $faqItem->title }}</a>
						</li>
					@endforeach	
					</ul>
				</div>	
			@endforeach
			</div>
		</div>
	</div>

@stop