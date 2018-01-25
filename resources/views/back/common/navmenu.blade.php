<div class="sidebar" data-background-color="white" data-active-color="info">

    <!--
        Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
        Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
    -->

    <div class="sidebar-wrapper" style="background-color: #121212;">
        <div class="logo">
            <a href="{{route('home') }}" class="simple-text">
                 Movies Online
            </a>
        </div>
        <ul class="nav admin-menu-list">


            <li class="dash-left-menu">
                <a href="{{route('admin.editmovies')}}">
                    <i class="fa fa-edit"></i>
                    <p>Edit Movies</p>
                </a>
            </li>

            <li class="dash-left-menu">
                <a href="{{route('admin.comments')}}">
                    <i class="fa fa-comment"></i>
                    <p>Comments</p>
                </a>
            </li>
            
            <li class="dash-left-menu">
                <a href="{{route('admin.useredit')}}">
                    <i class="fa fa-users"></i>
                    <p>Users</p>
                </a>
            </li>


            
        </ul>
    </div>
</div>
<script>
    $('.dash-left-menu a').click(function(){
        $('.dash-left-menu a').removeClass('active');
        $(this).addClass
    });
</script>