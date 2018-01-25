@extends('app')

@section('content')

    @include('menu')
    <div class="movie-page-bg-cover" style="display: flex;flex-direction: column;align-items: center;padding: 25px;">
        <div style="/*! display: block; */width: auto;float: left;margin: 0;" class="movie-data-cont">
            <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 25px;" class="notFound-cont">
                <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 10px 25px;text-align: center;" class="movie-comment">
                    <h2 style="padding: 15px;width: 100%;text-align: center;border-bottom: 1px dotted;margin: 0;/*! display: flex; */">Page Not Found!</h2>
                    <div style="font-size: 50px;padding: 15px;width: 100%;border-bottom: 1px dotted;display: flex;justify-content: center;align-items: center;padding-bottom: 20px;">
                        <span style="">404</span>
                    </div>
                    <h3>Sorry! this page doesn't exist.</h3>
                    <div style="/*! font-size: 50px; */padding: 15px;width: 100%;display: flex;justify-content: center;align-items: center;padding-bottom: 20px;">
                        <span style="">Try to Go Back</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('footer')
    {{--<script>--}}
        {{--$(document).ready(function(){--}}
            {{--var menuheight=$('.menu-ghost').height();--}}
            {{--var footerheight=$('#footer').height();--}}
            {{--var coverheight=$('#app').height();--}}
            {{--alert(coverheight-footerheight-menuheight);--}}
            {{--$('#app').css('height',coverheight-footerheight-menuheight);--}}
        {{--});--}}
    {{--</script>--}}
@stop