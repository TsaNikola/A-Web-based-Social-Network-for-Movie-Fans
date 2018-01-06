<div class="row">
    @foreach($movies as $movie)
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 movie-credit">
            <a href="{{route('movie',array('id'=>$movie['idMovie']))}}" class="credit-found-link" target="_blank">
                <div class="credit-grid-item row">
                    <div class="movie-credit-info-cont-outer movielist-info-cont-outer col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="movie-credit-img-cont  col-xs-12 col-sm-3 col-md-2 col-lg-2">
                            @if($movie['poster']!='')
                            <img class="movielist-img" alt="{{$movie['title']}}" src="https://image.tmdb.org/t/p/w130{{$movie['poster']}}">
                            @else
                            <img class="movielist-img" alt="{{$movie['title']}}" src="/cinema/public/img/no_avatar.jpg">
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
                                        <div style="float: left">
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
<div class="pegination">
    {{ $movies->links() }}
</div>