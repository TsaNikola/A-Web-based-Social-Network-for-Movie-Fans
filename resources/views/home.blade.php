@extends('app')

@section('content')
    @include('menu')
    @foreach($movies as $movie)
        {{--    {{$movie->title}}<br>--}}

    @endforeach

    <script>
        $(document).ready(function(){
        $('.home-box').hover(function(){
            var ribbonheight=$(this).find('.hb-ribbon').height();
                        var boxheight=$(this).height();
            var midheight=(boxheight/2)-(ribbonheight/2);
//                        var midheight=((boxheight-ribbonheight)/2)+(ribbonheight/2);
//            alert(midheight);
            $(this).find('.hb-ribbon').css('bottom',midheight);
            $(this).find('.hb-ribbon').css('visibility','visible');
            $(this).find('.hb-ribbon').css('opacity','1');
        },function () {
            $(this).find('.hb-ribbon').css('bottom','0');
            $(this).find('.hb-ribbon').css('visibility','hidden');
            $(this).find('.hb-ribbon').css('opacity','0');
        });
        });
    </script>


    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">



                <div class="home-boxes" id="main-box">
                    <div class="container-fluid">


                            <div class="series-cont-h row">

                                <div id="load-0">




                                    @foreach ($movies as $movie)
                                        {{--<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">--}}
                                                {{--<div class="hgrid">--}}
                                                    {{--<a class="hb-link" href="">--}}
                                                    {{--<div class="home-box @if($movie->releaseDate>=date("YYYY-mm-dd")) home @elseif($movie->popularity>=4) popular @endif">--}}

                                                        {{--@if($movie['poster']!='')--}}
                                                            {{--<div title="{{$movie->title}} ({{$movie->releaseDatereleaseDate}})" class="hb-image"><img src="https://image.tmdb.org/t/p/w130{{$movie['poster']}}"></div>--}}
                                                        {{--@elseif($movie['backdrop']!='')--}}
                                                            {{--<div title="{{$movie->title}} ({{$movie->releaseDate}})" class="hb-image" style="background-image: url('https://image.tmdb.org/t/p/w130/{{$movie['backdrop']}}')"></div>--}}
                                                        {{--@else--}}
                                                            {{--<div title="{{$movie->title}} ({{$movie->releaseDate}})" class="hb-image" style="background-image: url('/img/default_poster.jpg')"></div>--}}
                                                        {{--@endif--}}
                                                        {{--<div class="hb-title">--}}
                                                            {{--{{ $movie->title }}     @if($movie->releaseDate!=0) ({{substr($movie->releaseDate,0,4)}})         @endif--}}

                                                        {{--</div>--}}

                                                    {{--</div>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
                                            <div class="hgrid">
                                                <a class="hb-link" href="{{route('movie',array('id'=>$movie->idMovie))}}">
                                                    <div class="home-box @if($movie->releaseDate>=date("YYYY-mm-dd")) home @elseif($movie->popularity>=4) popular @endif">

                                                        @if($movie['poster']!='')
                                                            <div  class="hb-image"><img src="https://image.tmdb.org/t/p/w130{{$movie['poster']}}">
                                                                <div class="hb-ribbon">{{$movie->title}}   @if($movie->releaseDate!=0) ({{substr($movie->releaseDate,0,4)}})   @endif</div>
                                                            </div>
                                                       @else
                                                            <div class="hb-image" style="background-image: url('/img/default_poster.jpg')"></div>
                                                        @endif


                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                    @endforeach

                                    <div id="load-0-end"></div>

                                </div>


                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>





    </div>
    </div>


    <div class="pegination">
        {{ $movies->links() }}
    </div>
    @include('footer')

@endsection