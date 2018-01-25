@extends('app')

@section('content')
@include('menu')
<?php
header('X-Frame-Options:Allow-From https://www.youtube.com');
?>

    <div class="movie-page-bg" @if(count($backgrounds)>0) style="background-image: url('https://image.tmdb.org/t/p/original{{$backgrounds[array_rand($backgrounds)]}}');"@endif>
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
                            </div>
                        </div>
                    </div>

                </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="movie-info poster-cont">
                    @if($movie['poster']!='')
                        <img src="https://image.tmdb.org/t/p/w780{{$movie['poster']}}" class="poster-image">
                    @else
                        <img alt="{{$ra['title']}}-{{$ra['idComment']}}" src="{{Request::root()}}/img/default_poster.jpg.png" class="poster-image">
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 movie-details" style="min-height: 350px;">
                <div class="movie-info">
                    <div class="secondary-info">
                        <div class="info-left col-xs-12 col-sm-7 col-md-8 col-lg-8">
                            <div class="secondary-info-yrg">
                            <span class="quality-label">Year:</span>
                            <span class="quality">{{substr($movie['releaseDate'],0,4)}}</span>
                            <span class="quality-label genr">Rating:</span>
                                @if($movie['rating']==0)
                                    <span class="quality">N/A</span>
                                @else
                            <span class="quality">{{$movie['rating']}}</span>
                                @endif
                            <span class="quality-label genr">Genres:</span>
                            </div>
                            <ul class="genre">
                                @foreach($movie['genres'] as $genre)
                                <li>{{$genre}}</li>
                                    @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                            <button class=" movie-title-right" type=""><span class="quality-label">Followers:</span>
                                <span class="quality">{{count($movie['followers'])}}</span></button>
                            @if(Auth::check())
                                @if(!in_array(Auth::user()->idUser,$followersids))
                            <form method="POST" action="{{route('followmovie')}}">
                                {{ csrf_field() }}
                            <button class=" movie-title-right follow" name="movieid" value="{{$movie['idMovie']}}"><span class="quality-label">Follow</span>
                                </button>
                            </form>
                                @else
                                    <form method="POST" action="{{route('followmovie')}}">
                                        {{ csrf_field() }}
                                        <button class=" movie-title-right follow" name="movieid" value="{{$movie['idMovie']}}"><span class="quality-label">Unfollow</span>
                                        </button>
                                    </form>

                                @endif
                                @endif
                        </div>
                    </div>
                </div>
                <div class="movie-info">
                    <div class="secondary-info">
                        <div><span>Description</span></div>
                        @if($movie['description']!='' || $movie['description']!='Add the plot')
                        <div><span>{{$movie['description']}}</span></div>
                        @else
                            <div><span>There is no scenario description for {{$movie['title']}} yet.</span></div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="movie-menu" style="border-top-left-radius: 0;margin-bottom: 0;">
                    <div class="collapse navbar-collapse  movie-menu inner-movie-menu" style="border-top-left-radius: 0;">
                        <ul id="top-movie-menu-list" class="nav navbar-nav movie-menu-list" style="padding-bottom: 10px;">
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
                    <div class="dropdown">
                        <button class="btn-primary dropdown-toggle movie-menu-drop" type="button" data-toggle="dropdown">Comments
                            <span class="caret"></span></button>
                        <ul id="drop-movie-menu-list" class="dropdown-menu movie-menu-list">
                            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 active">
                                <a href="#movie-comments" >Comments</a>
                            </li>
                            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <a href="#movie-trailers" > Trailers</a>
                            </li>
                            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <a href="#movie-wallpapers">Wallpapers</a>
                            </li>
                            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <a  href="#movie-cast">Cast</a>
                            </li>
                            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <a  href="#movie-crew">Crew</a>
                            </li>
                            <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <a  href="#movie-followers">Followers</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="movie-comments" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="comment-cont" style="width: 100%">

                    @if(!Auth::check())

                            <div style="display: flex;justify-content: center;font-size: 18px;">
                                <span> You need to
                                    <a href="{{route('login')}}">login</a> or
                                    <a href="{{route('register')}}">register</a>
                                    in order to write a comment
                                </span>
                            </div>

                        @else

                        <form class="commentForm" method="POST" action="{{route('commentsubmit')}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="dbid" value="{{$movie['idMovie']}}">

                            <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="movie-comment new-comment-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="comment-user-image-outter col-xs-12 col-sm-2 col-md-2 col-lg-1 col-xl-1">

                                        @if(Auth::user()->image!='')
                                            <img alt="{{Auth::user()->username}}" src="{{Request::root()}}/uploads/users/images/{{Auth::user()->image}}" class="comment-image">
                                        @else
                                            <img alt="{{Auth::user()->username}}" src="{{Request::root()}}/img/no_avatar.jpg" class="comment-image">
                                        @endif

                                        <div class="comment-user-name">
                                            <span>{{Auth::user()->username}}</span>
                                        </div>
                                </div>

                                <div class="comment-user new-comment-txt-outter col-xs-12 col-sm-8 col-md-9 col-lg-10 col-xl-10">
                                    <textarea name="comment" class="form-control new-comment-txt"></textarea>
                                    <button  class="comment-user col-xs-3 col-sm-12 col-md-12 col-lg-12 col-xl-12 btn new-comment-sub" type="submit" name="submitcomment">Submit</button>
                                </div>
                            </div>

                            </div>

                        </form>

                        @endif
                        @if(count($movie['comments'])==0)
                            <div style="display: flex;justify-content: center;font-size: 18px;float: left;width: 100%;">
                                <span style="text-align: center;">There are no Comments yet for {{$movie['title']}}
                                </span>
                            </div>
                        @endif
                            @foreach($movie['comments'] as $comment)
                                <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="movie-comment inner-comment-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <a class="comment-user-image-outter col-xs-12 col-sm-2 col-md-2 col-lg-1 col-xl-1" href="{{route("user",array("id"=>$comment['userCommentId']))}}">
                                        <div class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">

                                            @if($comment['image']!='')
                                                <img alt="{{$comment['username']}}-{{$comment['idComment']}}" src="{{Request::root()}}/uploads/users/images/{{$comment['image']}}" class="comment-image">
                                            @else
                                                <img alt="{{$comment['username']}}-{{$comment['idComment']}}" src="{{Request::root()}}/img/no_avatar.jpg" class="comment-image">
                                            @endif
                                            <div class="comment-user-name">
                                                <span>{{$comment['username']}}</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="comment-user comment-date col-xs-12 col-sm-10 col-md-10 col-lg-11 col-xl-11">

                                        <div class="comment-user-date ">
                                            <span><i>{{date("M jS, Y - H:i",strtotime($comment['publishDate']))}}</i></span>
                                        </div>
                                    </div>
                                        <div class="comment-user comment-txt-outter col-xs-12 col-sm-8 col-md-9 col-lg-10 col-xl-10">
                                        <span class="comment-txt">{{$comment['content']}}</span>
                                    </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>
                </div>

                <div id="movie-trailers" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="trailer-widget">
                        @if(count($movie['trailers'])!==0)
                        <h2>Trailers</h2>
                        @endif
                        <div class=" row trailer-list">
                            @if(count($movie['trailers'])==0)
                                <div style="display: flex;justify-content: center;font-size: 18px;">
                                <span>There are no Trailers yet for {{$movie['title']}}
                                </span>
                                </div>
                            @endif
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
                    @if(count($movie['wallpapers'])==0)
                        <div style="display: flex;justify-content: center;font-size: 18px;">
                                <span>There are no Wallpapers yet for {{$movie['title']}}
                                </span>
                        </div>
                    @endif
                    @foreach($movie['wallpapers'] as $key=>$wallpaper)
                    <div id="wallpaper-{{$key+1}}-{{count($movie['wallpapers'])}}" class="wallpaper-cont col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <img alt="{{$movie['title']}}} | Wallpaper-{{$key}}" src="https://image.tmdb.org/t/p/original{{$wallpaper}}" class="wallpaper" style="width:100%;height:100%;">
                    </div>
                        @endforeach
                </div>

                <div id="movie-cast" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="credits-search-results row" style="margin-left: 15px;">
                        @if(count($movie['cast'])==0)
                            <div style="display: flex;justify-content: center;font-size: 18px;">
                                <span>There are no Cast information yet for {{$movie['title']}}
                                </span>
                            </div>
                        @endif
                        @foreach($movie['cast'] as $credit)
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 movie-credit">
                                <a href="{{route('credit',array('id'=>$credit['idPerson']))}}" class="credit-found-link">
                                    <div class="credit-grid-item row">
                                        <div class="movie-credit-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-img-cont  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                @if($credit['picture']!='')
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="https://image.tmdb.org/t/p/w154{{$credit['picture']}}">
                                                @else
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="{{Request::root()}}/img/no_avatar.jpg">
                                                @endif
                                            </div>
                                            <div class="movie-credit-info col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['name']}}</span></div>
                                                @if($credit['character']!='')
                                            <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['character']}}</span></div>
                                                    @endif
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
                        @if(count($movie['crew'])==0)
                            <div style="display: flex;justify-content: center;font-size: 18px;">
                                <span>There are no Crew information yet for {{$movie['title']}}
                                </span>
                            </div>
                        @endif
                        @foreach($movie['crew'] as $credit)
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 movie-credit">
                                <a href="{{route('credit',array('id'=>$credit['idPerson']))}}" class="credit-found-link">
                                    <div class="credit-grid-item row">
                                        <div class="movie-credit-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-img-cont  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                @if($credit['picture']!='')
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="https://image.tmdb.org/t/p/w154{{$credit['picture']}}">
                                                @else
                                                    <img class="credit-found-img" alt="{{$credit['name']}}" src="{{Request::root()}}/img/no_avatar.jpg">
                                                @endif
                                            </div>
                                            <div class="movie-credit-info col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['name']}}</span></div>
                                                @if($credit['character']!='')
                                                <div class="movie-credit-info-cont"><span class="movie-cast-name">{{$credit['character']}}</span></div>
                                                    @endif
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
                        @if(count($movie['followers'])==0)
                            <div style="display: flex;justify-content: center;font-size: 18px;">
                                <span>There are no Followers yet for {{$movie['title']}}
                                </span>
                            </div>
                        @endif
                        @foreach($movie['followers'] as $user)
                            <div class="user-found col-xs-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                <a href="{{route('user',array('id'=>$user['idUser']))}}" class="user-found-link">
                                    <div class="user-found-poster">
                                        @if($user['image']!='')
                                            <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$user['image']}}'); background-size: cover;background-position: center;"></div>
                                        @else
                                            <img alt="{{$user['username']}}" src="{{Request::root()}}/img/no_avatar.jpg">
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



<script>
    $(document).ready(function(){
$('#top-movie-menu-list').find('a').click(function(e){
    e.preventDefault();
    $('#top-movie-menu-list').find('a').each(function(){
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
$('#drop-movie-menu-list').find('a').click(function(e){
            e.preventDefault();
    $('.movie-menu-list').find('li').each(function(){
        $(this).removeClass('active');
    });
            $(this).parent().addClass('active');
            var tabid=$(this).attr('href');
            var tabtxt=$(this).text();
            $('.movie-menu-drop').text(tabtxt);
            $('.movie-menu-drop').append('<span class="caret"></span>');
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