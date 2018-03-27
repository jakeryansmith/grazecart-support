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
			<form action="/admin/topics/{{ $topic->id }}/articles/{{ $article->id }}/sections/{{ $section->id }}" method="POST" id="contentForm">
				{!! csrf_field() !!}
				{!! method_field('PUT') !!}
				<div class="panel">
					<div class="panel-body">
						<div class="form-group">
		                    <label>Title</label>
		                    <input type="text" name="title" class="form-control" value="{{ $section->title }}">
		                </div>
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
						<div class="form-group">
							<textarea 
								name="body" 
								class="form-control" 
								rows="10" 
								id="body_content"
							>{{ $section->body }}</textarea>
						</div>
						<div class="form-group">
							<label>Keywords</label>
							<input type="text" name="keywords" class="form-control" placeholder="Seperate keywords with commas" value="{{ $section->keywords }}">
						</div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ $section->slug }}">
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

@section('scripts')
<script>
	(function($R)
    {
        $R.add('plugin', 'save', {

            init: function(app)
            {
                this.app = app;

                // define toolbar service
                this.toolbar = app.toolbar;
            },
            start: function()
            {
                // set up the button
                var buttonData = {
                    title: 'Save',
                    api: 'plugin.save.toggle'
                };

                // add the button to the toolbar
                var $button = this.toolbar.addButton('save-button', buttonData);
            },
            toggle: function()
            {
                let content = this.app.source.getCode();
                window.eventHub.$emit('showProgressBar');
                $.ajax({
                    url: '/admin/topics/{{ $topic->id }}/articles/{{ $article->id }}/sections/{{ $section->id }}',
                    type: 'put',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'body': content
                    },
                    success: function(data)
                    {
                        window.eventHub.$emit('hideProgressBar');
                    }
                });
            }
        });
    })(Redactor);

    $('#body_content').redactor({
        buttons: ['format', 'bold', 'italic', 'image', 'ol', 'ul', 'link', 'html'],
        plugins: ['alignment','fullscreen','photo_manager','save'],
        formatting: ['p','h2','h3','h4'],
        formattingAdd: {
            "call-out": {
                title: 'Call Out',
                api: 'module.block.format',
                args: {
                    'tag': 'p',
                    'class': 'call-out'
                }
            },
            "call-out-alert": {
                title: 'Alert',
                api: 'module.block.format',
                args: {
                    'tag': 'p',
                    'class': 'call-out--alert'
                }
            }
        },
        styles: false,
        script: false,
        minHeight: 500,
    });
</script>
@stop