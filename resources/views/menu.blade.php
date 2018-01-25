<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="logo-container  "><img src="/cinema/public/img/logo.png" alt="logo"></div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed ham-menu" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="float: left;margin-left: 10px;">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav main-menu">
                <li><a href="{{route("home")}}">Home</a></li>
                <li class="dropdown dropdown-hover">
                    <a href=""  class="dropdown-toggle"> Movies</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('popular')}}" >Popular Movies</a></li>
                        <li><a href="{{route('toprated')}}" >Top Rated Movies</a></li>
                        <li><a href="{{route('latest')}}" >Latest Releases</a></li>
                        <li><a href="{{route('upcomming')}}" >Upcomming Movies</a></li>
                    </ul>
                </li>
                <li><a href="{{route('allusers')}}">Users</a></li>
                <li  class="dropdown dropdown-hover">
                    <a class="dropdown-toggle" href="#">Credits</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('allcast',array("a"))}}" >Cast</a></li>
                        <li><a href="{{route('allcrew',array("a"))}}" >Crew</a></li>
                    </ul>
                </li>
                <li>
                    <form method="POST" id="menuSearchForm" class="menuSearchForm" action="{{route('menusearch')}}">
                        {{ csrf_field() }}
                    <input type="text" class="menu-search" name="menusearch" value="" placeholder="Search">
                    </form>
                </li>
            </ul>

        </div>

            @if(!Auth::check())
            <ul class="nav navbar-nav user-menu">
            <li><a href="{{route('login')}}">Login</a></li>
            <li><a href="{{route('register')}}">Register</a></li>
            </ul>
            @else
            <ul class="nav navbar-nav user-menu">
                <li><a href="{{route('profile')}}">Profile</a></li>
                <li><a href="{{route('profilesettings')}}">Settings</a></li>
            {{--</ul>--}}
             {{--<ul class="nav navbar-nav user-menu" style="margin-left: 0;">--}}
                 @if(Auth::user()->privilages_level<3)
                     <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                 @endif
                 <li><a href="{{route('logout')}}">Logout</a></li>
            </ul>

            @endif

        <ul class="hamsearch">
            <li style="border-color: darkcyan;">
                <form method="POST" id="menuSearchFormham" class="menuSearchForm" action="http://localhost:8080/cinema/public/menu-search">
                    <input name="_token" value="hOCs6EB3Ynrtwne0NGWRqFpgxLllrSj3Lznd4dcp" type="hidden">
                    <input class="menu-search-ham" name="menusearch" value="" placeholder="Search" style="/*! text-align: center; */" type="text">
                </form>
            </li>
        </ul>
    </div>
</nav>
<div class="menu-ghost"></div>
<div class="search-container display-none"><div id="search-results" class="container"></div></div>
<script>
    $('.main-menu>li').hover(function(){
        $(this).css('border-color','cyan');
        $(this).prev().css('border-color','cyan');
    },function(){
        $(this).css('border-color','darkcyan');
        $(this).prev().css('border-color','darkcyan');
    });
    $('.menu-search').focus(function(){
        $(this).attr("placeholder",null);
        if($(this).val()!=='') {
            $('.search-container').removeClass('display-none');
            $('.home-boxes').addClass('display-none');
            $('.pegination').addClass('display-none');
            $('#footer').addClass('display-none');
        }
    });
    $('.menu-search-ham').focus(function(){
        $(this).attr("placeholder",null);
        if($(this).val()!=='') {
            $('.search-container').removeClass('display-none');
            $('.home-boxes').addClass('display-none');
            $('.pegination').addClass('display-none');
            $('#footer').addClass('display-none');
        }
    });
    $('.menu-search').on("focusout",function(){
        $(this).attr("placeholder","Search");
        });
    $('.menu-search-ham').on("focusout",function(){
        $(this).attr("placeholder","Search");
    });
    $('.menu-search').bind('keyup', function(){
        $('#menuSearchForm').submit();
    });
    $('.menu-search-ham').bind('keyup', function(){
        $('#menuSearchFormham').submit();
    });

    $('.search-container').click(function(e) {
        if (!($(e.target).attr('class') === 'search-container' || $(e.target).attr('class')==='search-close')){
            return;
    }
        $(this).addClass('display-none');
        $('.home-boxes').removeClass('display-none');
        $('.pegination').removeClass('display-none');
        $('#footer').removeClass('display-none');
    });
    $(".menuSearchForm").submit(function (event) {
        event.preventDefault();
        var searchval = $('.menu-search').val();
        if(searchval==''){
            searchval = $('.menu-search-ham').val();
        }
        if (searchval.length>2){
            $.ajax({
                type: "post",
                url: '{{route('menusearch')}}',
                data: $(this).serialize(),
                success: function (response) {
//                alert(response);
                    $('#search-results').children().remove();
                    if( $('.search-container').hasClass('display-none')){
                        $('.search-container').removeClass('display-none');
//                        $('.navbar-static-top').css('width','100%');
                        $('.home-boxes').addClass('display-none');
                        $('.pegination').addClass('display-none');
                        $('#footer').addClass('display-none');
                    }
                    $('#search-results').append(response);
                }
            });
    }
    });
</script>


