@extends('app')

@section('content')
@include('menu')
<?php
header('X-Frame-Options:Allow-From https://www.youtube.com');
?>

{{--<div style="width: 100%;height: 100vh; background: transparent url('https://image.tmdb.org/t/p/original{{$backgrounds[array_rand($backgrounds)]}}') no-repeat fixed center center / cover ; ">--}}

<div class="filter-cont">

</div>
    <div class="container">
        <div class="row filter">
            <form method="POST" id="movielistForm" class="movielistForm col-xs-12 col-sm-12 col-md-12 col-lg-12" action="{{route('post'.$list)}}">
                {{ csrf_field() }}
                <div class="filter-vals">
                <div class="filter-genres-cont">
                @foreach($allgenres as $genre)
                    @if(in_array($genre,$genres))
                        <input type="checkbox" name="genres[]" id="{{$genre}}-check" class="formgenres" value="{{$genre}}" checked/> <label for="{{$genre}}-check">{{$genre}}</label ><br/>
                    @else
                        <input type="checkbox" name="genres[]" id="{{$genre}}-check"  class="formgenres" value="{{$genre}}"/> <label for="{{$genre}}-check">{{$genre}}</label ><br/>
                    @endif
                    @endforeach
                {{--<div class="range-input-div">--}}
                    {{--<input type="range" multiple name="year-range" id="year-range" class="year-range" min="{{$fromYear}}" max="{{$toYear}}" oninput="updateTextInput(this.value);">--}}
                {{--</div>--}}
                </div>
                <div class="filter-year-cont">
                    <div>
                    <label for="fromyear" class="fromyear @if($fromYear!=1900) {{'year-changed'}} @endif">From Year:</label> <input class="filter-year fromyear @if($fromYear!=1900) {{'year-changed'}} @endif" id="fromyear" type="number" name="fromyear"  min="1900" max="{{date('Y',time())+20}}" size="4" value="{{$fromYear}}">
                    </div>
                    <div>
                    <label for="toyear" class="toyear @if($toYear!=date("Y",time())) {{'year-changed'}} @endif">to Year:</label> <input class="filter-year toyear @if($toYear!=date("Y",time())) {{'year-changed'}} @endif" id="toyear" type="number" size="4" min="1900" max="{{date('Y',time())+20}}" name="toyear" size="4" value="{{$toYear}}">
                    </div>
                </div>
                <input type="hidden" value="{{$currentPage}}" class="current-page-input"  name="page">
                <input type="hidden" value="{{$order}}" class="order-input"  name="order">
                <input type="hidden" value="{{$list}}" class="pagelist-input"  name="pagelist">
                </div>
                <div class="filter-go-cont">
                <input class="list-filter-submit" type="submit" value="Apply Filter" />
                </div>
            </form>
            <div class="filter-switch-cont">
                <div class="filter-switch">Hide Filter</div>
            </div>
        </div>
        <div class="movielist-cont">
        <div class="row">
@foreach($movies as $movie)
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 movie-credit">
                    <a href="{{route('movie',array('id'=>$movie['idMovie']))}}" class="credit-found-link" target="_blank">
                        <div class="credit-grid-item row">
                            <div class="movie-credit-info-cont-outer movielist-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="movie-credit-img-cont  col-xs-12 col-sm-3 col-md-2 col-lg-2">
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
<div class="pegination">
    {{ $movies->links() }}
</div>
    </div>

<div id="response"></div>
<script>
    $('.filter-year').on("change paste keyup",function(){
        $(this).css('box-shadow','0px 0px 8px rgba(0,255,255,0.6)');
        $(this).css('border-color','cyan');
        if( $(this).hasClass('fromyear')){
            $('.fromyear').css('text-shadow','1px 0px 3px cyan');
            $('.fromyear').css('color','white');
        }else{
            $('.toyear').css('text-shadow','1px 0px 3px cyan');
            $('.toyear').css('color','white');
        }
    });
    $('.filter-switch').click(function(){
        function displayNone() {
            $('#movielistForm').children().css('display','none')
        }
     if($(this).text()=='Hide Filter'){
         $('#movielistForm').css('height','0');
         $('#movielistForm').css('opacity','0.1');
         $('#movielistForm').css('min-height','1px');
         $('.list-filter-submit').css('display','none')
         $('.filter-switch').css('background','darkcyan');
         setTimeout(displayNone, 500);
         $(this).text('Show Filter');
     }else{
         $('#movielistForm').css('height','auto');
         $('#movielistForm').css('opacity','1');
         $('#movielistForm').css('min-height','170px');
         $('.list-filter-submit').css('display','block');
         $('.filter-switch').css('background','#004848');
         $('#movielistForm').children().css('display','flex');
         $(this).text('Hide Filter');
     }

    });
    $('.filter-switch').hover(function(){
        $('#movielistForm').css('box-shadow','0px 0px 8px rgba(0,255,255,0.6)');
    },function(){
        $('#movielistForm').css('box-shadow','');
    });
    </script>
@if(isset($genres[0]) || $fromYear!=1900 || $toYear!=date("Y"))
<script>

    $('.pagination a').click(function(e){
        e.preventDefault();
        var pagehreh=$(this).attr('href');
       var page= pagehreh.split("page=")
//        alert(page[1]);
        $('.current-page-input').val(page[1]);

        $('#movielistForm').submit();
    });
</script>
@endif
    @include('footer')

@endsection