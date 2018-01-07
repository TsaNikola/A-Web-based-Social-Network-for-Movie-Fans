@extends('app')

@section('content')
    @include('menu')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding: 25px;">
            <div class="register-cont">
              <div class="panel panel-default register-panel">
                <div class="register-heading">Login</div>

                <div class="panel-body  register-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 col-sm-4 control-label">E-Mail Address</label>

                            <div class="col-md-6 col-sm-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 col-sm-4 control-label">Password</label>

                            <div class="col-md-6 col-sm-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 col-sm-4 control-label"></label>
                            <div class="col-md-6 col-sm-6 col-md-offset-4">
                                <div class="checkbox">
                                    <input type="checkbox" id="rememberme" class="rememberme" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="rememberme" class="rememberme-label">Remember Me </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 control-label"></label>
                            <div class="col-md-8 col-sm-8 col-md-offset-3">
                                <button type="submit" class="btn btn-primary login-btn">
                                    Login
                                </button>

                                <a class="btn btn-link pass-forgot-btn" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>

    </div>
</div>
    <script>
        $('input').on("change paste keyup",function() {
            if ($(this).val()!='') {
                $(this).parent().prev().css('text-shadow', '0px 0px 8px rgba(0,255,255,0.6)');
                $(this).parent().prev().css('text-color', 'cyan');
            }else{
                $(this).parent().prev().css('text-shadow', '');
                $(this).parent().prev().css('text-color', '#fafafa');
            }
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .css('box-shadow','0px 0px 8px rgba(0,255,255,1)');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @include('footer')
@endsection
