@extends('admin.layouts.main')

@section('toolbar-breadcrumb')
    <li><a href="/admin/topics">Documentation</a></li>
    <li>{{ $topic->title }}</li>
@stop

@section('content')
	<ul class="nav">
		<li class="{{ request()->get('tab', 'articles') == 'articles' ? 'active' : '' }}">
			<a href="?tab=articles">Articles</a>
		</li>
		<li class="{{ request()->get('tab', 'articles') == 'settings' ? 'active' : '' }}">
			<a href="?tab=settings">Settings</a>
		</li>
	</ul>
	@if(request()->get('tab', 'articles') == 'articles')
    <articles :topic="{{ $topic }}"></articles>
    @else
    <div style="margin-top: 1px;" class="panel panel-tabs">
        <div class="panel-body">
            <form action="/admin/topics/{{ $topic->id }}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <div class="form-group">
                    <div class="radio">
                        <label class="mr-sm">
                            <input tabindex="1" type="radio" name="visible" value="1" @if($topic->visible) checked @endif> Visible
                        </label>
                        <label>
                            <input tabindex="1" type="radio" name="visible" value="0" @if(!$topic->visible) checked @endif> Hidden
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" name="icon" class="form-control" placeholder="fa-icon" value="{{ $topic->icon }}">
                </div> 
                <div class="form-group">
                    <label>Keywords</label>
                    <input type="text" name="keywords" class="form-control" placeholder="Seperate keywords with commas" value="{{ $topic->keywords }}">
                </div> 
                <div class="form-group">
                    <textarea name="description" rows="10" class="form-control">{{ $topic->description }}</textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-action">Save</button>
                </div>  
            </form>
        </div>
    </div>
    @endif
@stop
