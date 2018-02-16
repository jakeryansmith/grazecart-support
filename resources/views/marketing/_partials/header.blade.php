<div class="headerNavigation_container--fixed shadow">
    <div class="headerNavigation_innerContainer">

        <div class="headerNavigation_logoContainer">
            <a href="{{ url('/') }}">
                <div class="flex align-items-m">
                    <img src="{{ url('/images/logo.svg') }}" class="logo flex-item" alt="GrazeCart">
                    <img src="{{ url('/images/logo-square.svg') }}" class="logo-mobile flex-item" alt="GrazeCart">
                    <span class="flex-item logoLabel fs-sm bold">
                        Help
                    </span>    
                </div>    
            </a>
        </div>

        <div class="headerNavigation_searchContainer" id="instantSearch">
             <documentation-search></documentation-search>
        </div>

        <div class="headerNavigation_linksContainer">   
            <ul class="headerNavigation_items">  
                <li class="{{ request()->segment(1) == 'docs' ? 'active' : ''}}"><a href="{{ url('/docs') }}" class="text-gray">Docs</a></li>
                <li class="{{ request()->segment(1) == 'faqs' ? 'active' : ''}}"><a href="{{ url('/faqs') }}" class="text-gray">FAQ</a></li>
                <li class="{{ request()->segment(1) == 'guides' ? 'active' : ''}}"><a href="{{ url('/guides') }}" class="text-gray">Guides</a></li>
                <li><a href="https://facebook.com/groups/grazecartForum/" class="text-gray">Discussion</a></li>
            </ul>
        </div>

    </div>      
</div>