<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" href="/css/redactor.css">
    <link rel="stylesheet" href="{{ mix('/css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
    <script src="https://use.fontawesome.com/dc70a436ea.js"></script>
</head>
<body class="navigation-fixed-offset">
<div id="app">
    <div class="progress-bar" id="progressBar">
        <span></span>
    </div>
    <nav class="navigation-container--fixed hidden-print">
        @include('admin._partials.navigation')
        {{--Toolbar--}}
        <div class="toolbar">
            <div class="toolbar__breadcrumbs">
                <ul class="breadcrumb breadcrumb-toolbar">
                    @yield('toolbar-breadcrumb')
                </ul>
            </div>
            <div class="toolbar__buttons flex align-items-m">
                @yield('toolbar-buttons')
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="container">
            @yield('content')
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    $.Redactor.prototype.imagePlus = function()
    {
        return {
            init: function ()
            {
                var button = this.button.add('imagePlus', 'Image');
                this.button.addCallback(button, function() {
                    window.eventHub.$emit('toggleMediaBrowser');
                });
            }
        }
    }
    $('#body_content').redactor({
        buttons: ['format', 'bold', 'italic', 'image', 'ol', 'ul'],
        plugins: ['alignment','source','fullscreen','imagePlus'],
        formatting: ['p','h3','h4'],
        stylesClass: 'my-own-class',
        script: false,
        minHeight: 500
    });
</script>    
@yield('scripts')
</body>
</html>