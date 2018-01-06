@extends('app')

@section('content')
@include('menu')
<?php
header('X-Frame-Options:Allow-From https://www.youtube.com');
?>

{{--<div style="width: 100%;height: 100vh; background: transparent url('https://image.tmdb.org/t/p/original{{$backgrounds[array_rand($backgrounds)]}}') no-repeat fixed center center / cover ; ">--}}
    <div class="movie-page-bg" style="background-image: url('https://image.tmdb.org/t/p/original{{$backgrounds[array_rand($backgrounds)]}}');">
<div class="movie-page-bg-cover" >


    <div id="wallp-close" class="wallp-close display-none">
        <i class="fa fa-window-close" aria-hidden="true"></i>
    </div>

    <div id="left-arrow" class="wallp-arrow display-none">
        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
    </div>

    <div id="right-arrow" class="wallp-arrow display-none">
        <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
    </div>

    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="movie-info">
                    <div class="main-info">
                        <div class="title">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="movie-title">{{$movie['title']}}</div>
                                </div>
                                {{--<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">--}}
                                    {{--<button class=" movie-title-right" type=""><span class="quality-label">Followers:</span>--}}
                                        {{--<span class="quality">2</span></button>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                    {{--<div class="secondary-info">--}}
                        {{--<div class="info-left">--}}
                            {{--<span class="quality-label">Rating:</span>--}}
                            {{--<span class="quality">5.5</span>--}}
                            {{--<span class="quality-label genr">Genres:</span>--}}
                            {{--<ul class="genre">--}}
                                {{--<li></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="info-right">--}}
                            {{--<span class="quality-label">Display:</span>--}}
                            {{--<span class="quality">HD</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="movie-info poster-cont">
                    <img src="https://image.tmdb.org/t/p/w780{{$movie['poster']}}" class="poster-image">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 movie-details">
                <div class="movie-info">
                    {{--<div class="main-info">--}}
                    {{--<div class="title">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                    {{--<div class="movie-title">{{$movie['title']}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">--}}
                    {{--<button class=" movie-title-right" type=""><span class="quality-label">Followers:</span>--}}
                    {{--<span class="quality">2</span></button>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="secondary-info">
                        <div class="info-left col-xs-12 col-sm-7 col-md-8 col-lg-8">
                            <span class="quality-label">Year:</span>
                            <span class="quality">{{substr($movie['releaseDate'],0,4)}}</span>
                            <span class="quality-label genr">Rating:</span>
                            <span class="quality">{{$movie['rating']}}</span>
                            <span class="quality-label genr">Genres:</span>
                            <ul class="genre">
                                @foreach($movie['genres'] as $genre)
                                <li>{{$genre}}</li>
                                    @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                            <button class=" movie-title-right" type=""><span class="quality-label">Followers:</span>
                                <span class="quality">{{count($movie['followers'])}}</span></button>
                            <button class=" movie-title-right" type=""><span class="quality-label">Follow</span>
                                </button>
                        </div>
                    </div>
                </div>
                <div class="movie-info">
                    {{--<div class="main-info">--}}
                    {{--<div class="title">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                    {{--<div class="movie-title">{{$movie['title']}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">--}}
                    {{--<button class=" movie-title-right" type=""><span class="quality-label">Followers:</span>--}}
                    {{--<span class="quality">2</span></button>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="secondary-info">
                        <div><span>Description</span></div>
                        <div><span>{{$movie['description']}}</span></div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="movie-menu">
                    <div class="collapse navbar-collapse  movie-menu inner-movie-menu" >
                        <ul class="nav navbar-nav movie-menu-list">
                            <li class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                <a href="#movie-comments" class="active">Comments</a>
                            </li>
                            <li class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                <a href="#movie-trailers" > Trailers</a>
                            </li>
                            <li class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                <a href="#movie-wallpapers">Wallpapers</a>
                            </li>
                            <li  class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                <a  href="#movie-cast">Cast</a>
                            </li>
                            <li  class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                <a  href="#movie-crew">Crew</a>
                            </li>
                            <li  class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                <a  href="#movie-followers">Followers</a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div id="movie-comments" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="comment-cont">
                        @foreach($movie['comments'] as $comment)
                            <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <a href="{{route("user",array("id"=>$comment['userCommentId']))}}">
                                <div class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">

                                    @if($comment['image']!='')
                                        <img alt="{{$comment['username']}}-{{$comment['idComment']}}" src="/img/users/{{$comment['image']}}" class="comment-image">
                                    @else
                                        <img alt="{{$comment['username']}}-{{$comment['idComment']}}" src="/cinema/public/img/no_avatar.jpg" class="comment-image">
                                    @endif
                                        <div class="comment-user-name">
                                            <span>{{$comment['username']}}</span>
                                        </div>
                                </div>
                                </a>
                                <div class="comment-user col-xs-8 col-sm-9 col-md-12 col-lg-11 col-xl-11">

                                <div class="comment-user-date">
                                    <span><i>{{date("M jS, Y - H:i",strtotime($comment['publishDate']))}}</i></span>
                                </div>
                                </div>
                                <div class="comment-user col-xs-8 col-sm-9 col-md-12 col-lg-11 col-xl-11">
                                    <span>{{$comment['content']}}</span>
                                </div>

                            </div>

                        @endforeach
                    </div>

                </div>

                <div id="movie-trailers" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="trailer-widget">
                        <h2>Trailers</h2>
                        <div class=" row trailer-list">
                            @foreach($movie['trailers'] as $key=>$trailer)

                                            <iframe width="0" height="0" src="https://www.youtube.com/embed/{{$trailer['filename']}}" frameborder="0" allowfullscreen></iframe>

                            @endforeach
                            @foreach($movie['trailers'] as $key=>$trailer)
                            <div class="trailer-{{$key}} trailer-cont col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                <div class="trailer-box">
                                    <div class="tb-details">
                                        <strong>{{$trailer['tag']}}</strong>
                                    </div>

                                    <div class="tb-video">
                                          <iframe width="100%" height="auto" src="https://www.youtube.com/embed/{{$trailer['filename']}}" frameborder="0" allowfullscreen></iframe>
                                      </div>
                            </div>
                        </div>
                            @endforeach
                    </div>
                    </div>

                </div>

                <div id="movie-wallpapers" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    @foreach($movie['wallpapers'] as $key=>$wallpaper)
                    <div id="wallpaper-{{$key+1}}-{{count($movie['wallpapers'])}}" class="wallpaper-cont col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <img alt="{{$movie['title']}}} | Wallpaper-{{$key}}" src="https://image.tmdb.org/t/p/original{{$wallpaper}}" class="wallpaper" style="width:100%;height:100%;">
                    </div>
                        @endforeach
                </div>

                <div id="movie-cast" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="credits-search-results row" style="margin-left: 15px;">
                        @foreach($movie['cast'] as $credit)
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 movie-credit">
                                <a href="{{route('credit',array('id'=>$credit['idPerson']))}}" class="credit-found-link" target="_blank">
                                    <div class="credit-grid-item row">
                                        <div class="movie-credit-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-img-cont  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                @if($credit['picture']!='')
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="https://image.tmdb.org/t/p/w130{{$credit['picture']}}">
                                                @else
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="/cinema/public/img/no_avatar.jpg">
                                                @endif
                                            </div>
                                            <div class="movie-credit-info col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['name']}}</span></div>
                                            <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['character']}}</span></div>
                                            </div>
                                            @if($credit['birthday']!='')
                                                {{--                                <div class="mov-cast-info-cont"><span></span><span class="mov-cast-char"> {{ date("F jS, Y", strtotime($credit['birthday']))}}</span></div>--}}
                                            @else
                                                {{--<div class="mov-cast-info-cont"><span></span><span class="mov-cast-char">Undefined</span></div>--}}
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="movie-crew" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="credits-search-results row" style="margin-left: 15px;">
                        @foreach($movie['crew'] as $credit)
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 movie-credit">
                                <a href="{{route('credit',array('id'=>$credit['idPerson']))}}" class="credit-found-link" target="_blank">
                                    <div class="credit-grid-item row">
                                        <div class="movie-credit-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-img-cont  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                @if($credit['picture']!='')
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="https://image.tmdb.org/t/p/w130{{$credit['picture']}}">
                                                @else
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="/cinema/public/img/no_avatar.jpg">
                                                @endif
                                            </div>
                                            <div class="movie-credit-info col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['name']}}</span></div>
                                                <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['character']}}</span></div>
                                            </div>
                                            @if($credit['birthday']!='')
                                                {{--                                <div class="mov-cast-info-cont"><span></span><span class="mov-cast-char"> {{ date("F jS, Y", strtotime($credit['birthday']))}}</span></div>--}}
                                            @else
                                                {{--<div class="mov-cast-info-cont"><span></span><span class="mov-cast-char">Undefined</span></div>--}}
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="movie-followers" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="users-search-results row">
                        @foreach($movie['followers'] as $user)
                            <div class="user-found col-xs-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                <a href="{{route('user',array('id'=>$user['idUser']))}}" class="user-found-link">
                                    <div class="user-found-poster">
                                        @if($user['image']!='')
                                            <img alt="{{$user['username']}}" src="/img/users/{{$user['image']}}">
                                        @else
                                            <img alt="{{$user['username']}}" src="/cinema/public/img/no_avatar.jpg">
                                        @endif
                                        <span class="user-found-title">{{$user['username']}}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>

    </div>





    </div>
</div>

</div>

<script>
    $(document).ready(function(){
$('.movie-menu-list').find('a').click(function(e){
    e.preventDefault();
    $('.movie-menu-list').find('a').each(function(){
        $(this).removeClass('active');
    });
    $(this).addClass('active');
    var tabid=$(this).attr('href');
    $('.movie-data-cont').each(function(){
        $(this).css('display','none');
    });
    $(tabid).css('display','block');
    if(tabid=='#movie-trailers'){
        var trailerwidth=$('.tb-video').find('iframe').width();
        var trailerheight=trailerwidth*62/100;
        $('.tb-video').find('iframe').each(function(){
            $(this).css('height',trailerheight);
        });
    }
});
    });
</script>

<script>
    $(document).ready(function(){
        var currw=null;
        var maxw =null;
        $(".wallpaper-cont").click(function() {
            var info=$(this).attr('id');
            var infotmp= info.split('-');
            currw =parseInt(infotmp[1]);
            maxw =parseInt(infotmp[2]);

            if($('.wallp-close').hasClass('display-none')){
                $('.wallp-close').removeClass('display-none');
                $('.wallp-arrow').removeClass('display-none');
                $(this).addClass('wallpaper-cont-act');
                $(this).find('img').addClass('wallpaper-active ');
            }
            else{
                $('.wallp-close').addClass('display-none');
                $('.wallp-arrow').addClass('display-none');
                $(this).removeClass('wallpaper-cont-act');
                $(this).find('img').removeClass('wallpaper-active');
            }
        });
        $(".wallp-close").click(function() {
            // alert('clicked');
            $('.wallp-close').addClass('display-none');
            $('.wallp-arrow').addClass('display-none');
            $(".wallpaper-cont").removeClass('wallpaper-cont-act');
            $(".wallpaper-cont").find('img').removeClass('wallpaper-active');
        });
        $("#left-arrow").click(function() {
            $(".wallpaper-cont").removeClass('wallpaper-cont-act');
            $(".wallpaper-cont").find('img').removeClass('wallpaper-active');

            if(currw==1){
                currw=10;
            }else{
                currw-=1;
            }
            // alert("#wallpaper-"+currw+"-"+maxw);
            $("#wallpaper-"+currw+"-"+maxw).addClass('wallpaper-cont-act');
            $("#wallpaper-"+currw+"-"+maxw).find('img').addClass('wallpaper-active');
        });
        $("#right-arrow").click(function() {
            $(".wallpaper-cont").removeClass('wallpaper-cont-act');
            $(".wallpaper-cont").find('img').removeClass('wallpaper-active');

            if(currw==maxw){
                currw=1;
            }else{
                currw+=1;
            }
            // alert("#wallpaper-"+currw+"-"+maxw);
            $("#wallpaper-"+currw+"-"+maxw).addClass('wallpaper-cont-act');
            $("#wallpaper-"+currw+"-"+maxw).find('img').addClass('wallpaper-active');
        });
    });
</script>
    @include('footer')

@endsection