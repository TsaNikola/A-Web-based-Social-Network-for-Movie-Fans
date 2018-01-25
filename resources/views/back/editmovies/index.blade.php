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
     <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                    
                     <form method='post' action='{{ route('admin.editmovies') }}'>
                           {{ csrf_field() }}
            <div class="row" style="min-height: 50px;font-size: 17px;font-weight: bold;display: flex;justify-content: center;">
       <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1" style="text-align: center;">
        
          </div>
         <div style="text-align:center;width: auto;display: flex;justify-content: center;align-items: center;"  class="col-md-3 col-sm-3 col-lg-3 col-xs-3 admin-comments-input-cont">
         <span style="margin: 0 10px;">Update/Import Movies from </span>
             <input id="date" type="text" size="10" name="uidatefrom" placeholder="YYYY-MM-DD">
             <span style="margin: 0 10px;">to </span>
             <input id="date" type="text" size="11" name='uidateto' value="{{date('Y-m-d')}}">
         </div>
         <div style="text-align:center;width: auto;display: flex;justify-content: center;align-items: center;"  class="col-md-5 col-sm-5 col-lg-5 col-xs-5 admin-comments-input-cont">
         <input type='submit' class="admin-btn" name='updatefromto' value="Update" style="float: left; margin-right:15px;">
         <input type='submit' class="admin-btn" name='importfromto' value="Import" style="float: left;">
             </div>
         <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>
         
          </div>
                         
                     </form>
                         
           </div>

     <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="border-bottom: 1px solid rgba(0,0,0,0.1);">

         <form method='post' action='{{ route('admin.editmovies') }}'>
             {{ csrf_field() }}
             <div class="row" style="min-height: 50px;font-size: 17px;font-weight: bold;display: flex;justify-content: center;">
                 <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1" style="text-align: center;">

                 </div>
                 <div style="text-align:center;width: auto;display: flex;justify-content: center;align-items: center;"  class="col-md-3 col-sm-3 col-lg-3 col-xs-3 admin-comments-input-cont">
                     <select name="listjob">
                         <option value="update">Update</option>
                         <option value="import">Import</option>
                     </select>
                     <span style="margin: 0 10px;">Movies from </span>
                   <select name="listtype">
                       <option value="popular">Popular List</option>
                       <option value="top_rated">Top Rated List</option>
                   </select>

                 </div>
                 <div style="text-align:center;width: auto;display: flex;justify-content: center;align-items: center;"  class="col-md-5 col-sm-5 col-lg-5 col-xs-5 admin-comments-input-cont">
                     <input type='submit' class="admin-btn" name='getlist' value="Go">

                 </div>
                 <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>

             </div>

         </form>

     </div>

     <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="border-bottom: 1px solid rgba(0,0,0,0.1);">

         <form method='post' action='{{ route('admin.editmovies') }}'>
             {{ csrf_field() }}
             <div class="row" style="min-height: 50px;font-size: 17px;font-weight: bold;display: flex;justify-content: center;">
                 <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1" style="text-align: center;">

                 </div>
                 <div style="text-align:center;width: auto;display: flex;justify-content: center;align-items: center;"  class="col-md-3 col-sm-3 col-lg-3 col-xs-3 admin-comments-input-cont">
                     <select name="alljob">
                         <option value="updateall">Update all available movies</option>
                         <option value="importall">Import all available movies</option>
                     </select>

                 </div>
                 <div style="text-align:center;width: auto;display: flex;justify-content: center;align-items: center;"  class="col-md-5 col-sm-5 col-lg-5 col-xs-5 admin-comments-input-cont">
                     <input type='submit' class="admin-btn" name='getall' value="Go">

                 </div>
                 <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>

             </div>

         </form>

     </div>
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="border-bottom: 1px solid rgba(0,0,0,0.1);padding-top:15px;">
                    

            <div class="row" style="min-height: 50px;font-size: 17px;font-weight: bold;display: flex;justify-content: center;">
       <div  class="col-md-4 col-sm-4 col-lg-4 col-xs-4 admin-comments-input-cont" style="text-align: center;">
           <form method='post' id="adminSearchFormtitle" class="adminSearchForm" action='{{ route('admin.editmovies') }}'>
               {{ csrf_field() }}
           <input type='text' id="adminsearchInput" class="adminsearch" value="@if($title!=''){{$title}}@endif"  name='title' placeholder="Search by title" size="8" style="float: right; width: 100%;">
           </form>
       <div id="adminSearch-results" class="adminsearch-cont display-none">

       </div>
       </div>
                <form method='post' action='{{ route('admin.editmovies') }}'>
                    {{ csrf_field() }}
         <div style="text-align:center;width: auto;"  class="col-md-3 col-sm-3 col-lg-3 col-xs-3 admin-comments-input-cont">
             <input type='text' id="single-movie-id-input" value="@if($dbid!=0){{$dbid}}@endif"  name='dbid' placeholder=" ID" size="8" style="float: right;">
         </div>
         <div style="text-align:center;width: auto; display: flex;"  class="col-md-5 col-sm-5 col-lg-5 col-xs-5 admin-comments-input-cont">
         <input type='submit' class="admin-btn"  name='editmovie' value="Edit" style="float: left; margin-right:15px;">
           <input type='submit'  class="admin-btn" name='updatemovie' value="Update/Import" style="float: left;margin-right:15px;">
             <input type='submit' class="admin-btn" name='deletemovie' value="Delete" >
             </div>
         <div  class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>
                </form>
          </div>


    @if($deletemov!=0)

    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" >
        <div style="display: flex;justify-content: center;">
            @if($error!=0)
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 alert" >
                <div style="display: flex;justify-content: center;">
                     <span class="admin-comments-input-cont" style="text-align: center;color: #f37070;background: rgba(54, 0, 0, 0.5);">{{ $errortxt }}
                   <button style="margin-left: 8px;margin-top: -3px;margin-right: -3px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button></span>
                </div>
                </div>
        @else
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 alert alert-success" >
                    <div style="display: flex;justify-content: center;">
                     <span class="admin-comments-input-cont" style="text-align: center;">[{{$dbid}}] "{{$movie['title']}}" ({{$movie['year']}}) was deleted successfully.
                         <button style="margin-left: 8px;margin-top: -3px;margin-right: -3px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button></span>
                    </div>
                </div>

        @endif
        </div>

       </div>
       @endif

      @if($updatemov!=0)

    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" >
        <div style="display: flex;justify-content: center;">
                @if($error==0)
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 alert alert-success" >
                    <div style="display: flex;justify-content: center;">
                     <span class="admin-comments-input-cont" style="text-align: center;">[{{$dbid}}] "{{$movie['title']}}" ({{$movie['year']}}) was updated successfully.
                         <button style="margin-left: 8px;margin-top: -3px;margin-right: -3px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button></span>
                    </div>
                </div>
            @else
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 alert" >
                <div style="display: flex;justify-content: center;">
                     <span class="admin-comments-input-cont" style="text-align: center;color: #f37070;background: rgba(54, 0, 0, 0.5);">{{ $errortxt }}
                         <button style="margin-left: 8px;margin-top: -3px;margin-right: -3px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button></span>
                </div>
                </div>
        @endif
        </div>

       </div>
       @endif


        @if($editmov!=0 && $error!=0)
          <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 alert" >
        <div style="display: flex;justify-content: center;">
            <div style="display: flex;justify-content: center;">
                     <span class="admin-comments-input-cont" style="text-align: center;color: #f37070;background: rgba(54, 0, 0, 0.5);">{{ $errortxt }}
                         <button style="margin-left: 8px;margin-top: -3px;margin-right: -3px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button></span>
            </div>
                  </div>
       </div>
        @endif
   </div>

 </div>

   @if(($editmov!=0 || $updatemov!=0) && count($movie)>0)


          @if($backgrounds!='')
             <div class="movie-page-bg" style="max-height: 584px;min-height: 500px;overflow-x: hidden;background-image: url('https://image.tmdb.org/t/p/original{{$backgrounds[array_rand($backgrounds)]}}');">
                 <div class="movie-page-bg-cover" >
        @else
                         <div class="movie-page-bg" >
                             <div class="movie-page-bg-cover" >

        @endif

   <form method='post' action='{{ route('admin.editmovies') }}'>
 {{ csrf_field() }}
       <input type="hidden" name="dbid" value="{{$movie['idMovie']}}">
       <div class="container">

           <div class="row">

               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                   <div class="movie-info">
                       <div class="main-info">
                           <div class="title">
                               <div class="row">
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                       <input type="text" name="title" value="{{$movie['title']}}" class="movie-title" style="background: transparent;">
                                   </div>
                               </div>
                           </div>
                       </div>

                   </div>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                   <div class="movie-info poster-cont" style="flex-direction: column;">
                       <img src="https://image.tmdb.org/t/p/w780{{$movie['poster']}}" class="poster-image">
                       <input  type="text" name="poster" value="{{$movie['poster']}}" style="width: 100%;">
                   </div>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 movie-details">
                   <div class="movie-info">
                       <div class="secondary-info">
                           <div class="info-left col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <div class="secondary-info-yrg">
                                   <label for="edityear" class="quality-label">Year:</label>
                                   <input id="edityear" name="releasedate" type="text" value="{{$movie['releaseDate']}}" class="quality" size="10">
                                   <label for="editpopularity" class="quality-label">Popularity:</label>
                                   <input id="editpopularity"  name="popularity" type="text" value="{{$movie['popularity']}}" class="quality" size="10">
                                   <label for="editrating" id="editrating" class="quality-label">Rating:</label>
                                       <input type="text"  name="rating" value="{{$movie['rating']}}" class="quality" size="3">
                                   <label for="edittmdbid" class="quality-label">TMDB ID:</label>
                                   <input id="edittmdbid"  name="tmdbid" type="text" value="{{$movie['tmdbId']}}" class="quality" size="8">
                                   <div style="border: 1px solid;box-sizing: border-box;margin-top: 15px;padding: 5px;">
                                       <div class="quality-label" style="padding: 5px;padding-top: 0;border-bottom: 1px dotted gray;margin-bottom: 5px;">Genres:</div>
                                       @foreach($allgenres as $genre)
                                           @if(in_array($genre,json_decode($movie['genres'],true)))
                                               <input name="editgenres[]" id="{{$genre}}-check" class="formgenres" value="{{$genre}}" type="checkbox" checked>
                                           @else
                                               <input name="editgenres[]" id="{{$genre}}-check" class="formgenres" value="{{$genre}}" type="checkbox" >
                                           @endif

                                           <label for="{{$genre}}-check">{{$genre}}</label>

                                       @endforeach
                                   </div>
                           </div>

                       </div>
                       </div>
                   </div>
                   <div class="movie-info">

                       <div class="secondary-info">
                           <div class="quality-label" style="padding: 5px;padding-top: 0;border-bottom: 1px dotted gray;margin-bottom: 5px;">Description:</div>
                           <div><textarea name="description" style="width: 100%; height: auto;">{{$movie['description']}}</textarea></div>
                           <div class="col-md-6 col-sm-6 col-md-offset-4">
                               <button type="submit" name="editsubmit" class="btn btn-primary" style="border-bottom-left-radius: 20px;border-bottom-right-radius: 20px; margin:5px;">
                                   Save Changes
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
               {{--<div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 col-xl-12 movie-details">--}}
        {{--<div class="movie-info">--}}
            {{--<div class="secondary-info">--}}
                {{--<div class="info-left col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                    {{--<div class="secondary-info-yrg row" style="width: 100%;">--}}


                        {{--<div style="border: 1px solid;box-sizing: border-box;margin-top: 15px;padding: 5px;"  class="col-sm-4">--}}
                            {{--<div class="quality-label" style="padding: 5px;padding-top: 0;border-bottom: 1px dotted gray;margin-bottom: 5px;">Wallpapers:</div>--}}
                            {{--<textarea style="width: 100%; min-height: 175px;">--}}
                            {{--@foreach($movie['wallpapers'] as $wallpaper){{$wallpaper}},@endforeach--}}
                            {{--</textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="movie-info">--}}

            {{--<div class="secondary-info">--}}
                {{--<div><span>Description</span></div>--}}
                {{--<div><textarea name="description" style="background: transparent; width: 100%; height: auto;">{{$movie['description']}}</textarea></div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


           </div>

       </div>
   </form>


                             </div>

                         </div>
        </div>
    </div>
        
        
        
       </div>
       
       </div>
       @endif




                     
</div>
    
 
 
 
                 
                </div>
            </div>
            </div>
            @include('back.common.footer')
        </div>
    <!--</div>-->

    <script>

        $(document).ready(function () {
            $('.dash-left-menu a').each(function(){
                $(this).removeClass('active');
                var tmptxt=  $(this).text();
                if(tmptxt.indexOf('Edit Movies')>=0){
                    $(this).addClass('active');
                }
            });
            $('.adminsearch').bind('keyup', function(){
                  $('#adminSearchFormtitle').submit();
            });

            $(".adminSearchForm").submit(function (event) {
                event.preventDefault();

                var searchval = $('.adminsearch').val();

                if (searchval.length>2){
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
                            $('#adminSearch-results').children().remove();
                            if( $('#adminSearch-results').hasClass('display-none')){
                                $('#adminSearch-results').removeClass('display-none');
                            }
                            $('#adminSearch-results').append(response);
                        }
                    });
                }else if(!($('#adminSearch-results').hasClass('display-none'))){
                    $('#adminSearch-results').addClass('display-none');
                }
            });
        });
    </script>


@endsection
