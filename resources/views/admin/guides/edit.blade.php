@extends('admin.layouts.main')

@section('header')
<link rel="stylesheet" href="/css/redactor.css">
@stop

@section('toolbar-breadcrumb')
    <li><a href="/admin/guides">Guides</a></li>
    <li><a href="/admin/guides/{{ $guide->slug }}/edit">{{ $guide->title }}</a></li>
    <li>{{ $guide->title }}</li>
@stop

@section('content')
	<ul class="nav">
		<li class="{{ request()->get('tab', 'content') == 'content' ? 'active' : '' }}">
			<a href="?tab=content">Content</a>
		</li>
		<li class="{{ request()->get('tab', 'content') == 'settings' ? 'active' : '' }}">
			<a href="?tab=settings">Settings</a>
		</li>
	</ul>
	@if(request()->get('tab', 'content') == 'content')
	<div class="panel">
		<div class="panel-body">
			<form action="/admin/guides/{{ $guide->id }}" method="POST">
				{!! csrf_field() !!}
	    		{!! method_field('PUT') !!}
	    		<div class="form-group">
                    <div class="radio">
                        <label class="mr-sm">
                            <input tabindex="1" type="radio" name="draft" value="1" @if($guide->draft) checked @endif> Draft
                        </label>
                        <label>
                            <input tabindex="1" type="radio" name="draft" value="0" @if(!$guide->draft) checked @endif> Live
                        </label>
                    </div>
                </div>
                <div class="form-group">
                	<label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $guide->title }}">
                </div>
                <div class="form-group">
                	<label>Cover Photo</label>
                    <input type="text" name="cover_photo" class="form-control" value="{{ $guide->cover_photo }}">
                </div>
                <div class="form-group">
                	<label>Description</label>
                    <input type="text" name="description" class="form-control" value="{{ $guide->description }}">
                </div>
				@if($guide->draft)
					<div class="label label-light mb-sm">Draft</div>
					<button 
						type="button" 
						class="btn btn-sm btn-alt" 
						onclick="eventHub.$emit('toggleMediaBrowser')"
					><i class="fa fa-photo"></i> Add Image</button>
					<div class="form-group">
						<textarea 
							name="draft_body" 
							class="form-control" 
							rows="20" 
							placeholder="Use markdown to style text." 
							id="body_content"
						>{{ $guide->markdown('draft_body') }}</textarea>
					</div>
				@else
					<div class="form-group">
						<button 
						type="button" 
						class="btn btn-sm btn-alt" 
						onclick="eventHub.$emit('toggleMediaBrowser')"
					><i class="fa fa-photo"></i> Add Image</button>
						<textarea 
							name="body" 
							class="form-control" 
							rows="20" 
							placeholder="Use markdown to style text." 
							id="body_content"
						>{{ $guide->markdown('body') }}</textarea>
					</div>
				@endif
				<div class="form-group text-right">
		    		<button type="submit" class="btn btn-action">Save</button>
		    	</div>
	    	</form>	
		</div>
	</div>	
	@else
	<div style="margin-top: 1px;" class="panel panel-tabs">
		<div class="panel-body">
	    	<form action="/admin/guides/{{ $guide->id }}" method="POST">
	    		{!! csrf_field() !!}
	    		{!! method_field('PUT') !!}
	    		<div class="form-group">
                    <div class="radio">
                        <label class="mr-sm">
                            <input tabindex="1" type="radio" name="visible" value="1" @if($guide->visible) checked @endif> Visible
                        </label>
                        <label>
                            <input tabindex="1" type="radio" name="visible" value="0" @if(!$guide->visible) checked @endif> Hidden
                        </label>
                    </div>
                </div>
	    		<div class="form-group">
	    			<label>Keywords</label>
	    			<input type="text" name="keywords" class="form-control" placeholder="Seperate keywords with commas" value="{{ $guide->keywords }}">
	    		</div>	
	    		<div class="form-group">
	    			<textarea name="body" rows="10" class="form-control">{{ $guide->body }}</textarea>
	    		</div>

	    		<div class="form-group text-right">
	    			<button type="submit" class="btn btn-action">Save</button>
	    		</div>	
	    	</form>
	    </div>
	</div>
	@endif
	<media-browser id="body_content"></media-browser>
@stop
