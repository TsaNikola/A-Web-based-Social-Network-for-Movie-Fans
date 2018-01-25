@extends('layouts.back')
@section('content')
    <div class="wrapper">



        @include('back.common.navmenu')

        <div class="main-panel movie-page-bg-cover" style="width: calc(100% - 260px);overflow-x: hidden;">
            @include('back.layouts.topmenu')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 movie-page-bg-cover">



                        <div class="row">
                            <div>
                                <div class="row" style="min-height: 50px;font-size: 17px;font-weight: bold;display: flex;justify-content: center;background: linear-gradient(rgb(0, 0, 0,0.28), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0)) repeat scroll 0% 0% !important;">
                                    <div  class="col-md-4 col-sm-4 col-lg-4 col-xs-4 admin-comments-input-cont" >
                                        <form method='post' autocomplete="off" id="adminSearchFormtitle" class="adminSearchForm" action='{{ route('admin.comments') }}'>
                                            {{ csrf_field() }}
                                            <input type='text' id="adminsearchInput" class="adminsearcht admin-form-control" value="@if($type=='Movie' || $type=='Both'){{$title}}@endif"  name='title' placeholder="Search by movie title" size="8" style="float: right; width: 100%;">
                                        </form>
                                        <div id="adminSearch-results" class="adminsearch-cont display-none">

                                        </div>
                                    </div>
                                    <div  class="col-md-4 col-sm-4 col-lg-4 col-xs-4 admin-comments-input-cont" >
                                        <form method='post' autocomplete="off" id="adminSearchFormUsername" class="adminSearchForm" action='{{ route('admin.comments') }}'>
                                            {{ csrf_field() }}
                                            <input type='text' id="adminsearchInputUser" class="adminsearchu" value="@if($type=='User' || $type=='Both'){{$username}}@endif"  name='username' placeholder="Search by user Name" size="8" style="float: right; width: 100%;">
                                        </form>
                                        <div id="adminSearch-resultsu" class="adminsearch-cont display-none">

                                        </div>
                                    </div>
                                    <form method='post' action='{{ route('admin.comments') }}'>
                                        {{ csrf_field() }}

                                            <input type='hidden' id="single-movie-id-input" value="@if($type=='Movie' || $type=='Both'){{$latestComments[0]['movieCommentId']}}@endif"  name='movieid' >
                                            <input type='hidden' id="single-user-name-input" value="@if($type=='User' || $type=='Both'){{$latestComments[0]['userCommentId']}}@endif"  name='userid' >
                                            <input type='hidden' id="single-type-input" value="{{$type}}"  name='type' >

                                        <div style="text-align:center;width: auto;padding: 10px;"  class="col-md-5 col-sm-5 col-lg-5 col-xs-5 admin-comments-input-cont">
                                            <input type='submit'  name='showcomments' value="Show Comments" class="admin-btn">

                                        </div>
                                        <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>
                                    </form>
                                </div>
                                </div>
                            </div>

                        @if($type=='Movie')

                            <div id="movie-comments" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="comment-cont" style="width: 100%">



                                    @if(count($latestComments)==0)
                                        <div style="display: flex;justify-content: center;font-size: 18px;float: left;width: 100%;">
                                <span style="text-align: center;">There are no Comments yet for {{$movie['title']}}
                                </span>
                                        </div>
                                    @endif
                                    @foreach($latestComments as $comment)
                                        <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="movie-comment inner-comment-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-bottom: 0">
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
                                                <div class="comment-user-delete" style="float: right;min-height: 90px;">
                                                    <form method="POST" acrion="{{route('commentdelete')}}" style="bottom: 0;position: absolute;left: 0;width: 100%;">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="commentid" value="{{$comment['idComment']}}">
                                                        <input type="submits" value="Delete" name="delete" size="5">
                                                    </form>
                                                </div>
                                            </div>
                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </div>

                        @elseif($type=='User')
                            <div id="comments" class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="comment-cont" style="width: 100%">

                                    @foreach($latestComments as $comment)
                                        <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                            <a class="user-movie-comment-link" href="{{route("movie",array("id"=>$comment['movieCommentId']))}}">
                                                <div class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1">

                                                    @if($comment['poster']!='')
                                                        <img alt="{{$comment['title']}}-{{$comment['idComment']}}" src="https://image.tmdb.org/t/p/w130{{$comment['poster']}}" class="comment-image">
                                                    @else
                                                        <img alt="{{$comment['title']}}-{{$comment['idComment']}}" src="{{Request::root()}}/img/no_avatar.jpg" class="comment-image">
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



                                            </div>
                                            <div class="comment-user user-comment-content col-xs-8 col-sm-10 col-md-10 col-lg-11 col-xl-11">
                                                <span>{{$comment['content']}}</span>
                                            </div>
                                            <div class="comment-user-delete" style="float: right;min-height: 90px;">
                                                <form method="POST" acrion="{{route('commentdelete')}}" style="bottom: 0;position: absolute;left: 0;width: 100%;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="commentid" value="{{$comment['idComment']}}">
                                                    <input type="submits" value="Delete" name="delete" size="5">
                                                </form>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>

                        @else

                         <div id="Whats-up"  class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                            <div class="comment-cont" style="width: 100%">

                                @foreach($latestComments as $comment)
                                        <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="comment-user col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="height: 0;">

                                                <div class="comment-user-date profile-movie-followDate">
                                                    <span><i>{{date("M jS, Y - H:i",strtotime($comment['publishDate']))}}</i></span>
                                                </div>
                                            </div>
                                            <div class="comment-user commenter profile-recent-note col-xs-12 col-sm-9 col-md-12 col-lg-12 col-xl-12" style="display: flex;justify-content: center;padding: 10px;align-items: center;">
                                                <a href="{{route('user',array('id'=>$comment['user']['idUser']))}}" class="user-found-link"style="padding-right: 5px;">
                                                    <div class="user-found-poster" style="padding: 0;">
                                                        @if($comment['user']['image']!='')
                                                            <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$comment['user']['image']}}'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                        @else
                                                            <div class="user-image-div" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                        @endif
                                                    </div>
                                                </a>
                                                <span> <a href="{{route('user',array('userid'=>$comment['user']['idUser']))}}">{{$comment['user']['username']}}</a> Commented:</span>
                                            </div>
                                            <a class="comment-user-image-outter col-xs-4 col-sm-3 col-md-2 col-lg-1 col-xl-1" href="{{route("movie",array("id"=>$comment['movieCommentId']))}}">
                                                <div style="padding-bottom: 25px;">

                                                    @if($comment['poster']!='')
                                                        <img alt="{{$comment['title']}}-{{$comment['idComment']}}" src="https://image.tmdb.org/t/p/w130{{$comment['poster']}}" class="comment-image">
                                                    @else
                                                        <img alt="{{$comment['title']}}-{{$comment['idComment']}}" src="{{Request::root()}}/img/default_poster.jpg.png" class="comment-image">
                                                    @endif
                                                    <div class="comment-user-name">
                                                        <span>{{$comment['title']}}</span>
                                                    </div>
                                                </div>
                                            </a>

                                            <div class="comment-user comment-content col-xs-8 col-sm-9 col-md-12 col-lg-11 col-xl-11" style="display: flex;align-items: center;min-height: 80px;">
                                                <span>{{$comment['content']}}</span>
                                            </div>
                                            <div class="comment-user-delete" style="float: right;min-height: 90px;">
                                                <form method="POST" acrion="{{route('commentdelete')}}" style="bottom: 0;position: absolute;left: 0;width: 100%;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="commentid" value="{{$comment['idComment']}}">
                                                    <input type="submits" value="Delete" name="delete" size="5">
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>

                        @endif






                    </div>

                    </div>






                </div>





            </div>
        </div>
    </div>
    @include('back.common.footer')

    <!--</div>-->

    <script>
        $(document).ready(function () {
            $('.dash-left-menu a').each(function(){
                $(this).removeClass('active');
                var tmptxt=  $(this).text();
                if(tmptxt.indexOf('omment')>=0){
                    $(this).addClass('active');
                }
            });
            $('.adminsearcht').bind('keyup', function(){
                if($(this).val()==''){
                    $('#single-movie-id-input').val('');
                    if($('#single-type-input').val()=='Movie') {
                        $('#single-type-input').val('');
                    }
                }
                $('#adminSearchFormtitle').submit();
            });
            $('.adminsearchu').bind('keyup', function(){
                if($(this).val()==''){
                    $( '#single-user-name-input').val('');
                    if($('#single-type-input').val()=='User') {
                        $('#single-type-input').val('');
                    }
                }
                $('#adminSearchFormUsername').submit();
            });

            $(".adminSearchForm").submit(function (event) {
                event.preventDefault();

                var searchvalt = $('.adminsearcht').val();
                var searchvalu = $('.adminsearchu').val();
//                alert(searchvalu.length);
                if (searchvalu.length>2 || searchvalt.length>2){
//                    alert(searchvalu);
//                    alert( $(this).serialize());
                    $.ajax({
                        type: "post",
                        url: '{{route('adminsearch')}}',
                        data: $(this).serialize(),
                        error: function(xhr,textStatus,err)
                        {
                            console.log("readyState: " + xhr.readyState);
                            console.log("responseText: "+ xhr.responseText);
                            console.log("status: " + xhr.status);
                            console.log("text status: " + textStatus);
                            console.log("error: " + err);
                        },
                        success: function (response) {
//alert('ok');
                            if( response.indexOf("admin-search-movie")>=0) {
//                                alert(response.indexOf("admin-search-movie"));
                                $('#adminSearch-results').children().remove();
                                if ($('#adminSearch-results').hasClass('display-none')) {
                                    $('#adminSearch-results').removeClass('display-none');
                                }
                                $('#adminSearch-results').append(response);
                            }else if( response.indexOf("admin-search-users")>=0){
                                $('#adminSearch-resultsu').children().remove();
                                if ($('#adminSearch-resultsu').hasClass('display-none')) {
                                    $('#adminSearch-resultsu').removeClass('display-none');
                                }
                                $('#adminSearch-resultsu').append(response);
                            }
                        }
                    });
                }else if(!($('#adminSearch-results').hasClass('display-none'))){
                    $('#adminSearch-results').addClass('display-none');
                }else if(!($('#adminSearch-resultsu').hasClass('display-none'))){
                    $('#adminSearch-resultsu').addClass('display-none');
                }
            });
        });
    </script>


@endsection
