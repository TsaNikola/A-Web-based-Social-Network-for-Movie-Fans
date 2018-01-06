<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>

    <script src="https://use.fontawesome.com/ad269ee543.js"></script>

<link rel="shortcut icon" href="" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="movies,movies forum,movies community,follow movies,movies info,movies database,movie fans,cinema"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>Movies Community</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/style.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/cinema.css') }}" rel="stylesheet">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

   
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">

    <script src='https://www.google.com/recaptcha/api.js'></script>
   

    <!-- Scripts -->

<script>
    $(document).ready(function() { 

	(function ($) { 
		$('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
		
		$('.tab ul.tabs li a').click(function (g) { 
			var tab = $(this).closest('.tab'), 
				index = $(this).closest('li').index();
			
			tab.find('ul.tabs > li').removeClass('current');
			$(this).closest('li').addClass('current');
			
			tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
			tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
			
			g.preventDefault();
		} );
	})(jQuery);

});
</script>

</head>

<body>

    <div id="app" style="background: #191919;">

        @yield('content')

    <!-- Scripts -->

        <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    </div>
</body>
</html>
