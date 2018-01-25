@extends('layouts.back')
@section('content')
    <div class="wrapper">



        @include('back.common.navmenu')

        <div class="main-panel movie-page-bg-cover" style="width: calc(100% - 260px);">
            @include('back.layouts.topmenu')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 ">



                        <div class="row" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.0)) !important;">
                            <div>

                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="border-bottom: 1px solid rgba(0,0,0,0.1);padding-top:15px;">


                                    <div class="row" style="min-height: 50px;font-size: 17px;font-weight: bold;display: flex;justify-content: center;">
                                        <div  class="col-md-4 col-sm-4 col-lg-4 col-xs-4 admin-comments-input-cont" >
                                            <form method='post' autocomplete="off" id="adminSearchFormUsername" class="adminSearchForm" action='{{ route('admin.comments') }}'>
                                                {{ csrf_field() }}
                                                <input type='text' id="adminsearchInputUser" class="adminsearchu" value=""  name='username' placeholder="Search by user Name" size="8" style="float: right; width: 100%;">
                                            </form>
                                            <div id="adminSearch-resultsu" class="adminsearch-cont display-none" style="max-width: 525px;">

                                            </div>
                                        </div>
                                        <form method='post' action='{{ route('admin.useredit') }}'>
                                            {{ csrf_field() }}
                                            <div style="text-align:center;width: auto;"  class="col-md-3 col-sm-3 col-lg-3 col-xs-3 admin-comments-input-cont">
                                                <input type='text' id="single-user-name-input" value=""  name='userid' placeholder=" ID" size="8" style="float: right;">
                                            </div>
                                            <div style="text-align:center;width: auto; display: flex;"  class="col-md-5 col-sm-5 col-lg-5 col-xs-5 admin-comments-input-cont">
                                                <input type='submit' class="admin-btn"  name='edituser' value="Edit Privileges" style="float: left; margin-right:15px;">
                                                <input type='submit' class="admin-btn" name='deleteuser' value="Delete" >
                                            </div>
                                            <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>
                                        </form>
                                    </div>
                                    @if(Session::has('flash_message'))
                                        <div class="alert">
                                            <div style="display: flex;justify-content: center;">
                                           <span class="admin-comments-input-cont" style="text-align: center;color: #f37070;background: rgba(54, 0, 0, 0.5);">{{ Session::get('flash_message') }}
                                               <button style="margin-left: 8px;margin-top: -3px;margin-right: -3px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button></span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($user))
                                    <div class="movie-data-cont col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="movie-comment col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-left: 0;">
                                    <div class="comment-user commenter profile-recent-note col-xs-12 col-sm-9 col-md-12 col-lg-12 col-xl-12" style="display: flex; justify-content: center; padding: 10px  !important; align-items: center;">
                                        <a href="{{route("user",array("id"=>$user['idUser']))}}" class="user-found-link" style="padding-right: 5px;">
                                            <div class="user-found-poster" style="padding: 0px;">
                                                @if($user['image']!='')
                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/uploads/users/images/{{$user['image']}}'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                @else
                                                    <div class="user-image-div" style="background-image: url('{{Request::root()}}/img/no_avatar.jpg'); background-size: cover;background-position: center;max-width: 40px;max-height: 40px;border-radius: 50%;"></div>
                                                @endif
                                            </div>
                                        </a>
                                        <span><a href="{{route("user",array("id"=>$user['idUser']))}}">{{$user['username']}}</a>'s Privilege Level:</span>
                                        <form method='post' id="editPrivForm" class="edit-priv-form" action='{{ route('admin.useredit') }}'>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="userid" value="{{$user['idUser']}}">
                                        <input type='text' id="single-priv-lvl-input" value="{{$user['privilages_level']}}"  name='newprev' placeholder=" " size="1" style="float: right;border: none;margin-left: 5px;">
                                            {{--<input type='submit' class="admin-btn" name='savepriv' value="Save" >--}}
                                        </form>
                                    </div>
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
                if(tmptxt.indexOf('User')>=0){
                    $(this).addClass('active');
                }
            });
            $('.adminsearchu').bind('keyup', function(){
                $('#adminSearchFormUsername').submit();
            });
            $('#single-priv-lvl-input').bind('keyup', function(){
                var newpriv=parseInt($('#single-priv-lvl-input').val());
                if(newpriv>0) {
                    $('#editPrivForm').submit();
                }
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
