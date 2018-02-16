@extends('marketing.layout')

@section('content')
<div class="documentation_container">

	<div class="documentationNavigation_container">
		<button 
			type="button" 
			class="documentationNavigation_toggle align-items-m form-control" 
			onclick="toggleNavigation('documentationNavigation_list')"
		>Products <i class="push-right fas fa-angle-right" id="navigation_toggleIcon"></i>
		</button>

		<ul class="documentationNavigation_list hidden-mobile" id="documentationNavigation_list">
		@foreach($topics as $topicLink)
		<li class="documentationNavigation_listItem">
			<a href="{{ url('/docs/topic/'.$topicLink->slug) }}" class="bold fs-1 text-gray">
				{!! $topicLink->icon ?? '' !!}
				{{ $topicLink->title }}
			</a>
			@if($topic->id == $topicLink->id)
				<li>
					<ul class="ml-md mb-lg">
						@foreach($articles as $articleLink)
							@if($activeLink == $articleLink->slug)
								<li class="documentationNavigation_listItem active">
									<a 
										href="/docs/topic/{{ $topic->slug }}/article/{{ $articleLink->slug }}" 
										class="text-primary" 
									><i class="fas fa-angle-right"></i> {{ $articleLink->title }}</a>
								</li>
							@else
								<li class="documentationNavigation_listItem">
									<a 
										href="/docs/topic/{{ $topic->slug }}/article/{{ $articleLink->slug }}" 
										class="text-gray-medium" 
									>{{ $articleLink->title }}</a>
								</li>
							@endif	
						@endforeach
					</ul>
				</li>
			@endif	
		</li>
		@endforeach
		</ul>
	</div>

	<div class="article_container">
		<article class="article_innerContainer">
			<div class="article_section shadow-soft">
				<div class="article_sectionHeader article_sectionHeader--main">
					<ul class="article_breadcrumb mb-md">
						<li>
							<a href="{{ url('/') }}">Documentation</a>
						</li>
						<li>
							<a href="{{ url('/topic/'.$topic->slug) }}">{{ $topic->title }}</a>
						</li>
					</ul>	
					<h1 class="mb-sm article_header">
						{{ $article->title }}
					</h1>
					<div class="fs-sm text-soft_primary">Last updated {{ $article->updated_at->format('j M Y') }}</div>
				</div>	

				{{-- Table of contents --}}
				<div class="article_sectionBody">
					@if(count($article->sections) > 1)
						<div class="bold mb-md mt-md ml-md">Table of contents</div>
						<ul class="article_list mt-sm ml-md">
						@foreach($article->sections as $section)
							<li class="article_listItem mb-sm fs-1 lh-3">
								<a href="#{{ $section->slug }}">{{ $section->title }}</a>
							</li>
						@endforeach
						</ul>
					@endif
				</div>	
			</div>	

			@foreach($article->sections as $section)
				<a class="anchor" id="{{ $section->slug }}"></a>
				<div class="article_section shadow-soft">
					<div class="article_sectionHeader">
						<span class="text-gray bold">{{ $section->title }}</span>
					</div>
					<div class="article_sectionBody">
						{!! $section->body !!}
					</div>
				</div>
			@endforeach
		</article>
	</div>

</div>
@stop