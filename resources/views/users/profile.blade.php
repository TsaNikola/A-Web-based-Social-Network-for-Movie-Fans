@extends('app')

@section('content')
@include('menu')



<div class="movie-page-bg-cover" >




    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="movie-info">
                    <div class="main-info">
                        <div class="title">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="movie-title">{{$currentUser['username']}}</div>
                                </div>
                            </div>

                        </div>

                            @if(Auth::check() && Auth::user()->idUser!=$currentUser['idUser'])
                                @if(!in_array(Auth::user()->idUser,$followersids))
                                    <form method="POST" action="{{route('followuser')}}" style="position: absolute;top: 5px;right: 0;">
                                        {{ csrf_field() }}
                                        <button class=" movie-title-right follow" name="userid" value="{{$currentUser['idUser']}}"><span class="quality-label">Follow</span>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{route('followuser')}}" style="position: absolute;top: 5px;right: 0;">
                                        {{ csrf_field() }}
                                        <button class=" movie-title-right follow" name="userid" value="{{$currentUser['idUser']}}"><span class="quality-label">Unfollow</span>
                                        </button>
                                    </form>

                                @endif
                            @endif

                    </div>

                </div>
            </div>
            <div class="profile-top col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 movie-details user-info-big">

                    <div class="movie-info">
                        <div class="secondary-info">
                            @if($currentUser['info']!='')
                                <div style="padding-top: 7px;display: flex;justify-content: center;"><span>{{$currentUser['info']}}</span></div>
                            @else
                                <div style="padding-top: 7px;display: flex;justify-content: center;"><span>There is no scenario description for {{$currentUser['username']}} yet.</span></div>
                            @endif

                        </div>
                    </div>

                </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: flex; flex-direction: column;justify-content: center; align-items: center; max-width: 300px;">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="display: flex;justify-content: center;">

                <div class="movie-info poster-cont" style="border-radius: 50%;margin-bottom: 10px;">
                    @if($currentUser['image']!='')
                        <div class="user-image-div poster-image" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$currentUser['image']}}'); background-size: cover;background-position: center;max-width: 300px;width:100%; max-height: 300px;border-radius: 50%;"></div>
                    @else
                        <div class="user-image-div poster-image" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 200px; max-height: 200px; width:100%;border-radius: 50%;"></div>
                    @endif
                </div>


            </div>


            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 movie-details">

                <div class="movie-info">
                    <div class="secondary-info">
                        <div class="info-left col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: flex;justify-content: space-around;">

                            @if(count($genres)==0)
                                <span style="padding-top: 7px;width: 100%;text-align: center;">{{$currentUser['username']}} doesn't follow any movies yet</span>
                            @endif
                            <div class="genre genrelike-group ">
                                @foreach($genres as $k=>$genre)
                                    @if(array_search($k,array_keys($genres))<=(count($genres)-1)/2)
                                    <div class="genrelike"><span style="color: cyan">{{$k}}: </span><span>{{$genre['percent']}}%</span></div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="genre genrelike-group ">
                                @foreach($genres as $k=>$genre)
                                    @if(array_search($k,array_keys($genres))>(count($genres)-1)/2)
                                    <div class="genrelike"><span style="color: cyan">{{$k}}: </span><span>{{$genre['percent']}}%</span></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 movie-details user-info-mini">

                <div class="movie-info">
                    <div class="secondary-info">
                        @if($currentUser['info']!='')
                            <div style="padding-top: 7px;display: flex;justify-content: center;"><span>{{$currentUser['info']}}</span></div>
                        @else
                            <div style="padding-top: 7px;display: flex;justify-content: center;"><span>There is no scenario description for {{$currentUser['username']}} yet.</span></div>
                        @endif

                    </div>
                </div>

            </div>




            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="movie-menu">
                    @if(!Auth::check() || ($id!='' && $id!=Auth::user()->idUser) )
                    <div class="collapse navbar-collapse  movie-menu inner-movie-menu" >

                            <ul id="top-movie-menu-list"  class="nav navbar-nav movie-menu-list profile-menu">
                                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <a href="#recent-activity"  class="active">{{$currentUser['username']}}'s Recent Activity</a>
                                </li>
                                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <a href="#comments">{{$currentUser['username']}}'s Comments ({{count($comments)}})</a>
                                </li>
                                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <a  href="#movies">{{$currentUser['username']}}'s Movies ({{count($movies)}})</a>
                                </li>
                                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <a  href="#follows">{{$currentUser['username']}}'s Follows ({{count($follows)}})</a>
                                </li>
                                <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <a  href="#followers">{{$currentUser['username']}}'s Followers ({{count($followers)}})</a>
                                </li>
                            </ul>
                    </div>
                            <div class="dropdown">

                                <button class="btn-primary dropdown-toggle movie-menu-drop" type="button" data-toggle="dropdown">{{$currentUser['username']}}'s Recent Activity
                                    <span class="caret"></span></button>
                                <ul id="drop-movie-menu-list" class="dropdown-menu movie-menu-list">
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 active">
                                        <a href="#recent-activity"  class="active">{{$currentUser['username']}}'s Recent Activity</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a href="#comments">{{$currentUser['username']}}'s Comments ({{count($comments)}})</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a  href="#movies">{{$currentUser['username']}}'s Movies ({{count($movies)}})</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a  href="#follows">{{$currentUser['username']}}'s Follows ({{count($follows)}})</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a  href="#followers">{{$currentUser['username']}}'s Followers ({{count($followers)}}</a>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <div class="collapse navbar-collapse  movie-menu inner-movie-menu" >
                            <ul id="top-movie-menu-list"  class="nav navbar-nav movie-menu-list profile-menu">
                                <li class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <a href="#Whats-up" class="active">What's Up</a>
                                </li>
                                <li class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                    <a href="#recent-activity" >Recent Activity</a>
                                </li>
                                <li class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <a href="#comments">Comments ({{count($comments)}})</a>
                                </li>
                                <li  class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                    <a  href="#movies">Movies ({{count($movies)}})</a>
                                </li>
                                <li  class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                    <a  href="#follows">Follows ({{count($follows)}})</a>
                                </li>
                                <li  class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 dropdown dropdown-hover">
                                    <a  href="#followers">Followers ({{count($followers)}})</a>
                                </li>
                            </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn-primary dropdown-toggle movie-menu-drop" type="button" data-toggle="dropdown">What's Up
                                    <span class="caret"></span></button>
                                <ul id="drop-movie-menu-list" class="dropdown-menu movie-menu-list">
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 active">
                                        <a href="#Whats-up" >What's Up</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a href="#recent-activity" >Recent Activity</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a href="#comments">Comments ({{count($comments)}})</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a  href="#movies">Movies ({{count($movies)}})</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a  href="#follows">Follows ({{count($follows)}})</a>
                                    </li>
                                    <li class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                        <a  href="#followers">Followers ({{count($followers)}})</a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        @if(Auth::check() && $id==Auth::user()->idUser)
                                <div id="Whats-up"  class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                    <div class="comment-cont" style="width: 100%">

                                        @foreach($latestNews as $latestNew)
                                            @if(!isset($latestNew['idComment']))
                                                <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                                    <div class="comment-user col-xs-12 col-sm-9 col-md-12 col-lg-12 col-xl-12" style="height: 0;">

                                                        <div class="comment-user-date profile-movie-followDate">
                                                            <span><i>{{date("M jS, Y - H:i",strtotime($latestNew['followDate']))}}</i></span>
                                                        </div>
                                                    </div>
                                                    <div class="comment-user profile-recent-note col-xs-12 col-sm-9 col-md-12 col-lg-12 col-xl-12" style="display: flex;justify-content: center;align-items: center;">
                                                        <a href="{{route('user',array('id'=>$latestNew['user']['idUser']))}}" class="user-found-link"style="padding-right: 5px;">
                                                            <div class="user-found-poster" style="padding: 0;">
                                                                @if($latestNew['user']['image']!='')
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$latestNew['user']['image']}}'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @else
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                        <span>
                                                              @if(Auth::user()->idUser!=$latestNew['user']['idUser'])
                                                            <a href="{{route('user',array('userid'=>$latestNew['user']['idUser']))}}">{{$latestNew['user']['username']}}</a> Followed
                                                            @else
                                                                you
                                                            @endif
                                                            @if(Auth::user()->idUser!=$latestNew['idUser'])
                                                            <a href="{{route('user',array('userid'=>$latestNew['idUser']))}}">{{$latestNew['username']}} </a></span>
                                                        <a href="{{route('user',array('id'=>$latestNew['idUser']))}}" class="user-found-link"style="padding-left: 5px;">
                                                            <div class="user-found-poster" style="padding: 0;">
                                                                @if($latestNew['image']!='')
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$latestNew['image']}}'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @else
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                                @else
                                                            you</span>

                                                                @endif


                                                    </div>

                                                </div>
                                            @else
                                                <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <div class="comment-user col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="height: 0;">

                                                        <div class="comment-user-date profile-movie-followDate">
                                                            <span><i>{{date("M jS, Y - H:i",strtotime($latestNew['publishDate']))}}</i></span>
                                                        </div>
                                                    </div>
                                                    <div class="comment-user commenter profile-recent-note col-xs-12 col-sm-9 col-md-12 col-lg-12 col-xl-12" style="display: flex;justify-content: center;padding: 10px;align-items: center;">
                                                        @if(Auth::user()->idUser!=$latestNew['user']['idUser'])
                                                        <a href="{{route('user',array('id'=>$latestNew['user']['idUser']))}}" class="user-found-link"style="padding-right: 5px;">
                                                            <div class="user-found-poster" style="padding: 0;">
                                                                @if($latestNew['user']['image']!='')
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$latestNew['user']['image']}}'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @else
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                        <span> <a href="{{route('user',array('userid'=>$latestNew['user']['idUser']))}}">{{$latestNew['user']['username']}}</a> Commented:</span>
                                                        @else
                                                            <span>You Commented:</span>
                                                        @endif
                                                    </div>
                                                    <a class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1" href="{{route("movie",array("id"=>$latestNew['movieCommentId']))}}">
                                                        <div style="padding-bottom: 25px;">

                                                            @if($latestNew['poster']!='')
                                                                <img alt="{{$latestNew['title']}}-{{$latestNew['idComment']}}" src="https://image.tmdb.org/t/p/w154{{$latestNew['poster']}}" class="comment-image">
                                                            @else
                                                                <img alt="{{$latestNew['title']}}-{{$latestNew['idComment']}}" src="{{Request::root()}}/img/default_poster.jpg.png" class="comment-image">
                                                            @endif
                                                            <div class="comment-user-name">
                                                                <span>{{$latestNew['title']}}</span>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <div class="comment-user comment-content col-xs-8 col-sm-9 col-md-12 col-lg-11 col-xl-11" style="display: flex;align-items: center;min-height: 80px;">
                                                        <span>{{$latestNew['content']}}</span>
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>


                                <div id="recent-activity" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    @else
                                        <div id="recent-activity" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    @endif
                                    <div class="comment-cont" style="width: 100%">

                                        @foreach($recentActivity as $ra)
                                            @if(!isset($ra['idComment']))
                                            <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                                <div class="comment-user col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="height: 0;">

                                                    <div class="comment-user-date profile-movie-followDate">
                                                        <span><i>{{date("M jS, Y - H:i",strtotime($ra['followDate']))}}</i></span>
                                                    </div>
                                                </div>
                                                <div class="comment-user profile-recent-note col-xs-12 col-sm-9 col-md-12 col-lg-12 col-xl-12" style="display: flex;justify-content: center;align-items: center;"">

                                                    @if(!Auth::check() || (Auth::user()->idUser!=$id))
                                                        <span> {{$currentUser['username']}} Followed <a href="{{route('user',array('userid'=>$ra['idUser']))}}">{{$ra['username']}} </a></span>

                                                    @else
                                                        <span> You Followed <a href="{{route('user',array('userid'=>$ra['idUser']))}}">{{$ra['username']}} </a></span>
                                                    @endif
                                                        <a href="{{route('user',array('id'=>$ra['idUser']))}}" class="user-found-link"style="padding-left: 5px;">
                                                            <div class="user-found-poster" style="padding: 0;">
                                                                @if($ra['image']!='')
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$ra['image']}}'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @else
                                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                </div>
                                            </div>
                                            @else
                                                <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <a href="{{route("movie",array("id"=>$ra['movieCommentId']))}}">
                                                        <div class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">

                                                            @if($ra['poster']!='')
                                                                <img alt="{{$ra['title']}}-{{$ra['idComment']}}" src="https://image.tmdb.org/t/p/w154{{$ra['poster']}}" class="comment-image">
                                                            @else
                                                                <img alt="{{$ra['title']}}-{{$ra['idComment']}}" src="{{Request::root()}}/img/default_poster.jpg.png" class="comment-image">
                                                            @endif
                                                            <div class="comment-user-name">
                                                                <span>{{$ra['title']}}</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="comment-user col-xs-8 col-sm-10 col-md-10 col-lg-11 col-xl-11">

                                                        <div class="comment-user-date" style="float: left">
                                                            <span><i>{{date("M jS, Y - H:i",strtotime($ra['publishDate']))}}</i></span>
                                                        </div>

                                                    </div>
                                                    <div class="comment-user col-xs-8 col-sm-9 col-md-12 col-lg-11 col-xl-11">
                                                        <span>{{$ra['content']}}</span>
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div id="comments" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="comment-cont" style="width: 100%">

                                        @foreach($comments as $comment)
                                            <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                                <a class="user-movie-comment-link" href="{{route("movie",array("id"=>$comment['movieCommentId']))}}">
                                                    <div class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">

                                                        @if($comment['poster']!='')
                                                            <img alt="{{$comment['title']}}-{{$comment['idComment']}}" src="https://image.tmdb.org/t/p/w154{{$comment['poster']}}" class="comment-image">
                                                        @else
                                                            <img alt="{{$comment['title']}}-{{$comment['idComment']}}" src="{{Request::root()}}/img/default_poster.jpg.png" class="comment-image">
                                                        @endif
                                                        <div class="comment-user-name">
                                                            <span>{{$comment['title']}}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="comment-user comment-user-date-del-cont col-xs-8 col-sm-10 col-md-10 col-lg-11 col-xl-11">

                                                    <div class="comment-user-date" style="float: left">
                                                        <span><i>{{date("M jS, Y - H:i",strtotime($comment['publishDate']))}}</i></span>
                                                    </div>
                                                    @if(Auth::user()->idUser==$comment['userCommentId'])
                                                        <div class="comment-user-delete">
                                                            <form method="POST" acrion="{{route('commentdelete')}}">
                                                                {{ csrf_field() }}
                                                                <input type="submits" value="Delete" name="commentDel" size="5">
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="comment-user user-comment-content col-xs-8 col-sm-10 col-md-10 col-lg-11 col-xl-11">
                                                    <span>{{$comment['content']}}</span>
                                                </div>

                                            </div>

                                        @endforeach
                                    </div>
                                </div>

                                <div  id="movies" style="display: none;"  class="movie-data-cont movielist-cont">
                                    <div class="row">
                                        @foreach($movies as $movie)
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 movie-credit">
                                                    <a href="{{route('movie',array('id'=>$movie['idMovie']))}}" class="credit-found-link">
                                                        <div class="credit-grid-item row">
                                                            <div class="movie-credit-info-cont-outer movielist-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="profile-movie-follow-date" style="float: right;position: absolute;right: 15px;top: 5px;color: #c4c4c4;"><span>{{date("M jS, Y - H:i",strtotime($movie['followDate']))}}</span></div>
                                                                <div class="movie-credit-img-cont profile-movie-img-cont  col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                                                    @if($movie['poster']!='')
                                                                        <img class="movielist-img" alt="{{$movie['title']}}" src="https://image.tmdb.org/t/p/w154{{$movie['poster']}}">
                                                                    @else
                                                                        <img class="movielist-img" alt="{{$movie['title']}}" src="{{Request::root()}}/img/default_poster.jpg.png">
                                                                    @endif
                                                                </div>
                                                                <div class="movielist-info  col-xs-12 col-sm-9 col-md-10 col-lg-10">
                                                                    <div class="title">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                                <div class="movie-title movielist-title">{{$movie['title']}}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="secondary-info">
                                                                        <div class="info-left info-left-movielist col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                            <div style="float: left">
                                                                                <span class="quality-label">Year:</span>
                                                                                <span class="quality">{{substr($movie['releaseDate'],0,4)}}</span>
                                                                            </div>
                                                                            <div style="float: left">
                                                                                <span class="quality-label genr">Rating:</span>
                                                                                <span class="quality">{{$movie['rating']}}</span>
                                                                            </div>
                                                                            <div class="profile-movie-genre-outter" style="float: left">
                                                                                <div style="float: left">
                                                                                    <span class="quality-label genr">Genres:</span>
                                                                                </div>
                                                                                <div  class="movielist-genre-cont">
                                                                                    <ul class="movielist-genre profile-move-genre-list">
                                                                                        @foreach($movie['genres'] as $key=>$genre)
                                                                                            @if(count($movie['genres'])-1>$key)
                                                                                                <li>{{$genre}},</li>
                                                                                            @else
                                                                                                <li>{{$genre}}</li>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="movie-info movielist-sec-info">

                                                                        <div class="secondary-info">
                                                                            <div class="movielist-description">{{$movie['description']}}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>


                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <div id="follows" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="users-search-results row">
                                        @foreach($follows as $user)
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

                                <div id="followers" style="display: none;" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="users-search-results row">
                                        @foreach($followers as $user)
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
                {{--</div>--}}

            </div>
            </div>

    </div>

    </div>

<script>
    $(document).ready(function(){
        $('.poster-image').height($('.poster-image').width());
        $('.poster-cont').width($('.poster-cont').height());
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
    @include('footer')

@endsection