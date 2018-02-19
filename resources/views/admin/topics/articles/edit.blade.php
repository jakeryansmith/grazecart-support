@extends('admin.layouts.main')

@section('header')
<link rel="stylesheet" href="/css/redactor.css">
@stop

@section('toolbar-breadcrumb')
    <li><a href="/admin/topics">Documentation</a></li>
    <li><a href="/admin/topics/{{ $topic->slug }}/edit">{{ $topic->title }}</a></li>
    <li>{{ $article->title }}</li>
@stop

@section('content')
	<ul class="nav">
		<li class="{{ request()->get('tab', 'sections') == 'sections' ? 'active' : '' }}">
			<a href="?tab=sections">Sections</a>
		</li>
		<li class="{{ request()->get('tab', 'sections') == 'settings' ? 'active' : '' }}">
			<a href="?tab=settings">Settings</a>
		</li>
	</ul>
	@if(request()->get('tab', 'sections') == 'sections')
		<edit-article :topic="{{ $topic }}" :article="{{ $article }}"></edit-article>
	@else
	<div style="margin-top: 1px;" class="panel panel-tabs">
		<div class="panel-body">
	    	<form action="/admin/topics/{{ $topic->id }}/articles/{{ $article->id }}" method="POST">
	    		{!! csrf_field() !!}
	    		{!! method_field('PUT') !!}
	    		<div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $article->title }}">
                </div> 
	    		<div class="form-group">
                    <div class="radio">
                        <label class="mr-sm">
                            <input tabindex="1" type="radio" name="visible" value="1" @if($article->visible) checked @endif> Visible
                        </label>
                        <label>
                            <input tabindex="1" type="radio" name="visible" value="0" @if(!$article->visible) checked @endif> Hidden
                        </label>
                    </div>
                </div>
	    		<div class="form-group">
	    			<label>Keywords</label>
	    			<input type="text" name="keywords" class="form-control" placeholder="Seperate keywords with commas" value="{{ $article->keywords }}">
	    		</div>	
	    		<div class="form-group">
	    			<textarea name="body" rows="10" class="form-control">{{ $article->body }}</textarea>
	    		</div>

	    		<div class="form-group text-right">
	    			<button type="submit" class="btn btn-action">Save</button>
	    		</div>	
	    	</form>
	    </div>
	</div>
	@endif
@stop
