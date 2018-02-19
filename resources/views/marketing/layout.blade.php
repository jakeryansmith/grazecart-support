<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>{{ $pageTitle ?? 'GrazeCart: The Shopping Cart For Small Farms' }}</title>
    <meta charset="utf-8">
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="direct marketing, small farms, grassfed, ecommerce, seven sons farms">
    <meta name="description" content="{{ $page_description or '' }}">
    <meta name="referrer" content="origin">
    <meta name="twitter:site" content="@GrazeCart" />
    @yield('head')
    <link rel="stylesheet" href="{{ mix('/css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-17234537-8"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-17234537-8');
    </script>
</head>

<body>
@include('marketing._partials.header')

<div class="main">
    @yield('page_header')
    <div class="main_container {{ $layout ?? 'main_container--default' }}">
        @yield('content')
    </div>
    @yield('page_footer')
    <div class="footer_container">
        <div class="footer_innerContainer">
            <div>
                <div class="bold fs-1 mb-sm footer_heading">GrazeCart</div>
                <ul>
                    <li><a href="https://grazecart.com/get-started">Start your trial</a></li>
                    <li><a href="https://grazecart.com/pricing">Pricing</a></li>
                    <li><a href="https://grazecart.com/about">About Us</a></li>
                    <li><a href="https://grazecart.com/blog">Blog</a></li>
                </ul>    
            </div>

            <div>
                <div class="bold fs-1 mb-sm footer_heading">Support</div>
                <ul>
                    <li><a href="https://grazecart.com/contact">Contact Us</a></li>
                    <li><a href="{{ url('/faqs') }}">FAQ</a></li>
                    <li><a href="{{ url('/guides') }}">Guides</a></li>
                    <li><a href="https://www.facebook.com/grazecart/">Discussion</a></li>
                </ul>    
            </div>

            <div>
                <div class="bold fs-1 mb-sm footer_heading">Resources</div>
                <ul>
                    <li><a href="http://kimhitzfieldphotography.zenfolio.com/">Stock Photos</a></li>
                    <li><a href="https://grassfedexchange.com">The Grassfed Exchange</a></li>
                    <li><a href="https://hengear.com">Rollout Nest Boxes</a></li>
                </ul>    
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap-dropdown.min.js"></script>
<script src="/js/marketing.js"></script>
<script>
    function toggleNavigation(id)
    {
        document.getElementById(id).classList.toggle('hidden-mobile');
        var icon = document.getElementById('navigation_toggleIcon');

        if(icon.classList.contains('fa-angle-right'))
        {
            icon.classList.remove('fa-angle-right');
            icon.classList.add('fa-angle-down');
        }
        else
        {
            icon.classList.remove('fa-angle-down');
            icon.classList.add('fa-angle-right');
        }
    }
</script>    
@yield('scripts')
</body>
</html>