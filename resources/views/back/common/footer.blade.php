<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
          
        </nav>
        <div class="copyright pull-right">
            &copy; <script>document.write(new Date().getFullYear())</script>
        </div>
    </div>
</footer>
@section('scripts')
<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="js/bootstrap-checkbox-radio.js"></script>

<!--  Charts Plugin -->
<script src="js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="js/bootstrap-notify.js"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="js/paper-dashboard.js"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="js/demo.js"></script>

<script type="text/javascript">

    $(document).ready(function(){

        demo.initChartist();

        $.notify({
            icon: 'ti-user',
            message: "Welcome to <b>Dashboard</b>"

        },{
            type: 'info',
            timer: 4000
        });

    });

</script>
@endsection