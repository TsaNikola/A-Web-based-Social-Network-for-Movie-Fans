@extends('app')

@section('content')
@include('menu')



<div class="movie-page-bg-cover" >




    <div class="container">

        <div class="row">
            <div id="follows" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="users-search-results row">
                    @foreach($allusers as $user)
                        <div class="user-found col-xs-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                            <a href="{{route('user',array('id'=>$user->idUser))}}" class="user-found-link">
                                <div class="user-found-poster">
                                    @if($user->image!='')
                                        <div class="user-image-div" style="background-image: url('{{ env('APP_URL') }}/uploads/users/images/{{$user->image}}'); background-size: cover;background-position: center;"></div>
                                    @else
                                        <img alt="{{$user->username}}" src="{{Request::root()}}/img/no_avatar.jpg">
                                    @endif
                                    <span class="user-found-title">{{$user->username}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>

        <div class="pegination credits-pagination">
            {{ $allusers->links() }}
        </div>
    </div>

    </div>

    @include('footer')

@endsection