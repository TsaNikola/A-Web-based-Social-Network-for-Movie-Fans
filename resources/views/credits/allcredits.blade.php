@extends('app')

@section('content')
@include('menu')


    <div class="movie-page-bg" >
<div class="movie-page-bg-cover" >



    <div class="container">

        <div class="row">
            <div class="pegination alpha-pagination">
                <ul class="pagination alphabet">
                    @foreach($alphabet as $ab)

                     @if($firstChar==$ab)
                    <li class="active"><a href="{{route('all'.$creditype,array($ab))}}">{{strtoupper($ab)}}</a></li>
                     @else
                            <li><a href="{{route('all'.$creditype,array($ab))}}">{{strtoupper($ab)}}</a></li>
                     @endif
                    @endforeach
                </ul>

            </div>

                <div id="movie-cast" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                    <div class="credits-search-results row" style="margin-left: 15px;">
                        @foreach($credits as $credit)
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
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
        </div>

        <div class="pegination credits-pagination">
            {{ $credits->links() }}
        </div>

</div>


    </div>


    @include('footer')

@endsection