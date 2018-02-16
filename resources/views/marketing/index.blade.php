@extends('marketing.layout')

@section('page_header')
	<div class="pageHeader_container">
		<div class="pageHeader_innerContainer">
			<div class="fs-5 bold mb-sm">GrazeCart Support</div>
			<div class="fs-normal text-primary-9 lh-4 ml-xs">What can we help you with today?</div>	
		</div>
	</div>	
@stop

@section('content')
	<div class="helpIndex_container">	
		<div class="helpIndex_innerContainer">
			<a href="/docs" class="helpIndex_card pa-lg shadow-soft">

				<div class="flex align-items-t">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="fas fa-info-circle"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-s text-indent-minus-2">
							Docs
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Learn how GrazeCart works and what all it can do
						</div>
					</div>
				</div>

			</a>

			<a href="/faqs" class="helpIndex_card pa-lg shadow-soft">
				<div class="flex align-items-t">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="far fa-question-circle"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-sm text-indent-minus-2">
							FAQ
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Answers to our most-popular questions
						</div>
					</div>
				</div>
			</a>

			<a href="/guides" class="helpIndex_card pa-lg shadow-soft">
				<div class="flex align-items-t">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="fas fa-user-circle"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-sm text-indent-minus-2">
							Guides
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Step by step in-depth walkthroughs
						</div>
					</div>
				</div>
			</a>

			<a href="https://www.facebook.com/grazecart/" class="helpIndex_card pa-lg shadow-soft">
				<div class="flex align-items-t">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="far fa-comments"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-sm text-indent-minus-2">
							Discussion
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Ask the GrazeCart community questions
						</div>
					</div>
				</div>
			</a>

			<a href="https://grazecart.com/contact" class="helpIndex_card pa-lg shadow-soft">
				<div class="flex align-items-t">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="far fa-envelope-open"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-sm text-indent-minus-2">
							Email Support
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Send us an email support ticket
						</div>
					</div>
				</div>
			</a>

			{{-- <a href="#" class="helpIndex_card pa-lg shadow-soft">
				<div class="flex align-items-t">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="far fa-handshake"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-sm text-indent-minus-2">
							Consulting
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Paid consulting from expert direct marketers <em>(coming soon)</em>
						</div>
					</div>
				</div>
			</a> --}}

			<a href="http://kimhitzfieldphotography.zenfolio.com/" class="helpIndex_card pa-lg shadow-soft">
				<div class="flex align-items-b">
					<div class="flex-item fs-6 mr-lg text-primary-7">
						<i class="fas fa-image"></i>
					</div>
					<div class="flex-item">
						<div class="text-gray fs-4 bold mb-sm text-indent-minus-2">
							Stock Photos
						</div>
						<div class="lh-3 fs-1 text-gray-5">
							Professional stock photography for farms
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
@stop








