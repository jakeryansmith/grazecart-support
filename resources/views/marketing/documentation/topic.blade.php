@extends('marketing.layout' , [
		'pageTitle' => $article->title,
		'layout' => 'main_container--docs'
	])

@section('content')
<div class="documentation_container">
	<div class="documentation_innerContainer">

		<div class="documentationNavigation_container">
			<button 
				type="button" 
				class="documentationNavigation_toggle align-items-m form-control" 
				onclick="toggleNavigation('documentationNavigation_list')"
			><span class="flex-item ml-sm">Products</span><i class="flex-item push-right fas fa-angle-right mr-sm" id="navigation_toggleIcon"></i>
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
				<div class="article_headerContainer">
					<div>
						<h1 class="mb-sm article_header">
							{{ $article->title }}
						</h1>
						<div class="fs-sm text-gray-7">Last updated {{ $article->updated_at->format('j M Y') }}</div>
					</div>	

					{{-- Table of contents --}}
					<div>
						@if(count($article->sections) > 1)
							<div class="bold mt-lg">Table of contents</div>
							<ul class="article_list ml-md mt-md">
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
					<div class="article_section">
						<a class="anchor" id="{{ $section->slug }}"></a>
						<div class="article_sectionHeader lh-3 fs-2 bold">
							{{ $section->title }}
						</div>
						<div class="article_sectionBody">
							{!! $section->body !!}
						</div>
					</div>	
				@endforeach
			</article>
		</div>

	</div>
</div>	
@stop