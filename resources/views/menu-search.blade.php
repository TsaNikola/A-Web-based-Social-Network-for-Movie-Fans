<script>
    $(document).ready(function(){
        $('.home-box').hover(function(){
            var ribbonheight=$(this).find('.hb-ribbon').height();
            var boxheight=$(this).height();
            var midheight=(boxheight/2)-(ribbonheight/2);
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
<span class="search-close">X</span>
<div class="container-fluid search-results-container ">

    <ul class="search-tabs nav navbar-nav">
        @if(isset($movies[0]))
            <li class="search-tab active">
                <span>Movies Found</span>
            </li>
        @endif
        @if(isset($credits[0]))
                <li class="search-tab @if(!isset($movies[0])) active @endif">
                    <span>Credits Found</span>
                </li>
        @endif
            @if(isset($users[0]))
                <li class="search-tab @if(!isset($movies[0]) && !isset($credits[0])) active @endif">
                    <span>Users Found</span>
                </li>
            @endif
    </ul>

@if(isset($movies[0]))
    <div class="movies-search-results row">
        @foreach($movies as $movie)
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="hgrid">
                    <a class="hb-link" href="{{route('movie',array('id'=>$movie->idMovie))}}">
                        <div class="home-box @if($movie->releaseDate>=date("YYYY-mm-dd")) home @elseif($movie->popularity>=4) popular @endif">

                            @if($movie['poster']!='')
                                <div class="hb-image"><img src="https://image.tmdb.org/t/p/w130{{$movie['poster']}}">
                                    <div class="hb-ribbon">{{$movie->title}}   @if($movie->releaseDate!=0) ({{substr($movie->releaseDate,0,4)}})   @endif</div>
                                </div>
                            @else
                                <div  class="hb-image" style="background-image: url('/cinema/public/img/default_poster.jpg')"></div>
                            @endif


                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

    @if(isset($credits[0]))
        <div class="credits-search-results row display-none">
            @foreach($credits as $credit)
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 movie-credit">
                    <a href="{{route('credit',array('id'=>$credit->idPerson))}}" class="credit-found-link" target="_blank">
                        <div class="credit-grid-item row">
                            <div class="credit-found-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="credit-found-img-cont  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    @if($credit->picture!='')
                                        <img class="credit-found-img" alt="{{$credit->name}}" src="https://image.tmdb.org/t/p/w130{{$credit->picture}}">
                                    @else
                                        <img class="credit-found-img" alt="{{$credit->name}}" src="/cinema/public/img/no_avatar.jpg">
                                    @endif
                                </div>
                                <div class="user-found-info-cont"><span></span><span class="mov-cast-name">{{$credit->name}}</span></div>
                                @if($credit->birthday!='')
{{--                                <div class="mov-cast-info-cont"><span></span><span class="mov-cast-char"> {{ date("F jS, Y", strtotime($credit->birthday))}}</span></div>--}}
                                @else
                                 {{--<div class="mov-cast-info-cont"><span></span><span class="mov-cast-char">Undefined</span></div>--}}
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($users[0]))
        <div class="users-search-results row display-none">
            @foreach($users as $user)
                <div class="user-found col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <a href="{{route('user',array('id'=>$user->idUser))}}" class="user-found-link">
                        <div class="user-found-poster">
                            @if($user->image!='')
                            <img alt="{{$user->username}}" src="/img/users/{{$user->image}}">
                            @else
                                <img alt="{{$user->username}}" src="/cinema/public/img/no_avatar.jpg">
                            @endif
                            <span class="user-found-title">{{$user->username}}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</div>
@if(!isset($movies[0]) && !isset($credits[0]) && !isset($users[0]))
    <div class="search-no-results"><span>No Results Found</span></div>
@endif

<script>
    $(document).ready(function(){
        if($('.search-tabs .active').find('span').text()=='Movies Found'){
            if($('.movies-search-results').hasClass('display-none')) {
                $('.movies-search-results').removeClass('display-none');
                $('.movies-search-results').addClass('display-block');
                $('.credits-search-results').addClass('display-none');
                $('.users-search-results').addClass('display-none');
            }
        }else if($('.search-tabs .active').find('span').text()=='Credits Found'){
            if($('.credits-search-results').hasClass('display-none')){
                $('.credits-search-results').removeClass('display-none');
                $('.credits-search-results').addClass('display-block');
                $('.users-search-results').addClass('display-none');
                $('.movies-search-results').addClass('display-none');
            }
        }else if($('.search-tabs .active').find('span').text()=='Users Found'){
            if( $('.users-search-results').hasClass('display-none')) {
                $('.users-search-results').removeClass('display-none');
                $('.users-search-results').addClass('display-block');
                $('.credits-search-results').addClass('display-none');
                $('.movies-search-results').addClass('display-none');
            }
        }

$('.search-tab').click(function(){
    if($(this).find('span').text()=='Movies Found'){
        if($('.movies-search-results').hasClass('display-none')) {
            $('.movies-search-results').removeClass('display-none');
            $('.movies-search-results').addClass('display-block');
            $('.credits-search-results').addClass('display-none');
            $('.users-search-results').addClass('display-none');
        }
    }else if($(this).find('span').text()=='Credits Found'){
        if($('.credits-search-results').hasClass('display-none')){
            $('.credits-search-results').removeClass('display-none');
            $('.credits-search-results').addClass('display-block');
            $('.users-search-results').addClass('display-none');
            $('.movies-search-results').addClass('display-none');
        }
    }else if($(this).find('span').text()=='Users Found'){
        if( $('.users-search-results').hasClass('display-none')) {
            $('.users-search-results').removeClass('display-none');
            $('.users-search-results').addClass('display-block');
            $('.credits-search-results').addClass('display-none');
            $('.movies-search-results').addClass('display-none');
        }
    }
    $('.search-tab').removeClass('active');
    $(this).addClass('active');
});
    });
</script>