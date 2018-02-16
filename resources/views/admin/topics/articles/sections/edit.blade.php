@extends('admin.layouts.main')

@section('header')

@stop

@section('toolbar-breadcrumb')
    <li><a href="/admin/topics">Documentation</a></li>
    <li><a href="/admin/topics/{{ $topic->slug }}/edit">{{ $topic->title }}</a></li>
    <li><a href="/admin/topics/{{ $topic->slug }}/articles/{{ $article->slug }}/edit">{{ $article->title }}</a></li>
    <li>{{ $section->title }}</li>
@stop

@section('content')
	@if($errors->count())
		<ul>
		@foreach ($errors->all() as $message)
		<li>{{ $message }}</li>
		@endforeach
		</ul>
	@endif
	<div class="row">
		<div class="content">
			<form action="/admin/topics/{{ $topic->id }}/articles/{{ $article->id }}/sections/{{ $section->id }}" method="POST">
				{!! csrf_field() !!}
				{!! method_field('PUT') !!}
				<div class="panel">
					<div class="panel-body">
						<div class="form-group">
		                    <div class="radio">
		                        <label class="mr-sm">
		                            <input tabindex="1" type="radio" name="visible" value="1" @if($section->visible) checked @endif> Visible
		                        </label>
		                        <label>
		                            <input tabindex="1" type="radio" name="visible" value="0" @if(!$section->visible) checked @endif> Hidden
		                        </label>
		                    </div>
		                </div>
		                <div class="form-group">
							<label>Description</label>
							<input type="text" name="description" class="form-control" placeholder="A short description for search results" value="{{ $section->description }}">
						</div>
						<div class="form-group text-right">
							<button 
								type="button" 
								class="btn btn-sm btn-alt" 
								onclick="eventHub.$emit('toggleMediaBrowser')"
							><i class="fa fa-photo"></i> Add Image</button>
						</div>
						<div class="form-group">
							<textarea 
								name="body" 
								class="form-control" 
								rows="10" 
								placeholder="Use markdown to style text." 
								id="body_content"
							>{{ $section->markdown() }}</textarea>
						</div>
						<div class="form-group">
							<label>Keywords</label>
							<input type="text" name="keywords" class="form-control" placeholder="Seperate keywords with commas" value="{{ $section->keywords }}">
						</div>
						<div class="form-group">
							<label>URL</label>
							<input type="text" name="url" class="form-control" value="{{ $section->url }}">
						</div>
					</div>
					<div class="text-right panel-footer">
						<button type="submit" class="btn btn-action">Save Changes</button>
					</div>	
				</div>
			</form>
			<media-browser id="body_content"></media-browser>
		</div>
	</div>		
@stop