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
                                    <div class="movie-title">{{$credit['name']}}</div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <div class="profile-top col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: flex; flex-direction: column;justify-content: center; align-items: center; max-width: 300px;">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="display: flex;justify-content: center;">

                <div class="movie-info poster-cont" style="border-radius: 50%;margin-bottom: 10px;">
                    @if($credit['picture']!='')
                        <div class="user-image-div poster-image" style="background-image: url('https://image.tmdb.org/t/p/w154{{$credit['picture']}}'); background-size: cover;background-position: center;max-width: 300px;width:100%; max-height: 300px;border-radius: 50%;"></div>
                    @else
                        <div class="user-image-div poster-image" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 200px; max-height: 200px; width:100%;border-radius: 50%;"></div>
                    @endif
                </div>


            </div>


            </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 person-info">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 col-xl-12 movie-details">

                <div class="movie-info">
                    <div class="secondary-info">
                        <div class="info-left col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: flex;justify-content: space-around;">
                            <div class="secondary-info-yrg" style="min-width: 100px;">
                                <span class="quality-label" style="padding-right: 3px;">Birthday:</span>
                                @if($credit['birthday']!='')
                                <span class="quality">{{date("M jS, Y",strtotime($credit['birthday']))}}</span>
                                @else
                                    <span class="quality">N/A</span>
                                @endif
                            </div>
                            <div class="secondary-info-yrg" style="min-width: 100px;">
                                <span class="quality-label genr" style="padding-right: 3px;">Birthplace:</span>
                                @if($credit['birthplace']!='')
                                    <span class="quality">{{$credit['birthplace']}}</span>
                                    @else
                                    <span class="quality">N/A</span>
                                    @endif

                            </div>
                            <div class="secondary-info-yrg" style="min-width: 100px;">
                                <span class="quality-label genr" style="padding-right: 3px;">Website:</span>
                                @if($credit['website']!='')
                                <span class="quality"><a href="{{$credit['website']}}" target="_blank"> {{str_replace('http://','',str_replace('https://','',$credit['website']))}}</a></span>
                                @else
                                    <span class="quality">N/A</span>
                                @endif
                            </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 col-xl-12 movie-details user-info-mini" style="display: flex;">

                    <div class="movie-info">
                        <div class="secondary-info">
                            @if($credit['biography']!='')
                                <div style="padding-top: 7px;display: flex;justify-content: center;"><span>{{$credit['biography']}}</span></div>
                            @else
                                <div style="padding-top: 7px;display: flex;justify-content: center;"><span>There is no biography for {{$credit['name']}} yet.</span></div>
                            @endif

                        </div>
                    </div>

                </div>
                </div>




            </div>
            <div style="display: flex;justify-content: center;align-items: center;width: 100%;">
            <div class="filter-go-cont" style="width: calc(100% - 50px);float: left;">
                <div class="list-filter-submit" style="display: flex;justify-content: center;align-items: center;text-shadow: #002121 5px 0px 9px;
box-shadow: 0px 2px 5px rgba(0,0,0,0.05) inset,0px 0px 8px rgba(0,255,255,0.6); padding:3px;">
                    <span>{{$credit['name']}} participated in the following movies:</span>
                </div>
            </div>
            </div>
            <div id="Whats-up"  class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top: 0;">

                <div class="comment-cont" style="width: 100%; padding-right: 0;">

                    @foreach($movies as $movie)
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 movie-credit">
                                <a href="{{route('movie',array('id'=>$movie['idMovie']))}}" class="credit-found-link" style="display: flex;justify-content: center;align-items: center;">
                                    <div class="credit-grid-item row">
                                        <div class="movie-credit-info-cont-outer movielist-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="movie-credit-img-cont  col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                                @if($movie['poster']!='')
                                                    <img class="movielist-img" alt="{{$movie['title']}}" src="https://image.tmdb.org/t/p/w154{{$movie['poster']}}">
                                                @else
                                                    <img class="movielist-img" alt="{{$movie['title']}}" src="/cinema/public/img/default_poster.jpg.png">
                                                @endif
                                            </div>
                                            <div class="movielist-info  col-xs-12 col-sm-9 col-md-10 col-lg-10">
                                                @if($movie['part']=='cast')
                                                <div class="secondary-info">
                                                    <div class="info-left info-left-movielist col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div style="float: left">
                                                            <span class="quality-label">Character:</span>
                                                            <span class="quality">{{$movie['character']}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                    <div class="secondary-info">
                                                        <div class="info-left info-left-movielist col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div style="float: left">
                                                                <span class="quality-label">As </span>
                                                                <span class="quality">{{$movie['character']}} </span>
                                                                <span class="quality-label">At:</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
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
                                                        <div style="float: left">
                                                            <div style="float: left">
                                                                <span class="quality-label genr">Genres:</span>
                                                            </div>
                                                            <div  class="movielist-genre-cont" >
                                                                <ul class="movielist-genre">
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
                                                        @if($movie['description']!='' || $movie['description']=='Add the plot')
                                                            <div class="movielist-description">{{$movie['description']}}</div>
                                                        @else
                                                            <div><span>There is no scenario description for {{$movie['title']}} yet.</span></div>
                                                        @endif

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


        </div>




            </div>

    <div class="pegination credits-pagination">
        {{ $movies->links() }}
    </div>


    </div>


<script>
    $(document).ready(function(){
        $('.poster-image').height($('.poster-image').width()+$('.poster-image').width()*0.5);
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