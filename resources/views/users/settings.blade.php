@extends('app')

@section('content')
@include('menu')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding: 25px;">
            <div class="register-cont">
              <div class="panel panel-default register-panel">
                <div class="register-heading">Profile Settings</div>

                <div class="panel-body register-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('postprofilesettings') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="userimage-input" class=" col-sm-4 control-label">User Image</label>

                            <div class="col-md-6 col-sm-6">
                                <label class="userimage-label" for="userimage-input">
                                    @if($currentUser['image']!='')
                                        <img alt="{{$currentUser['username']}}" id="blah" src="{{Request::root()}}/uploads/users/images/{{$currentUser['image']}}">
                                    @else
                                    <img alt="{{$currentUser['username']}}" id="blah" src="{{Request::root().'/img/no_avatar.jpg'}}"  />
                                    @endif
                                </label>
                                <input type="file"  id="userimage-input" class="form-control" name="userimage" accept="image/*" onchange="readURL(this);"/>

                                @if ($errors->has('userimage'))
                                    <span class="help-block" style="color: red;">
                                        <strong>{{ str_replace('userimage','file',$errors->first('userimage')) }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 col-sm-4 control-label">E-Mail Address</label>

                            <div class="col-md-6 col-sm-6">
                                <input id="email" type="email" class="form-control" name="email" value="" placeholder="{{ $currentUser['email'] }}" >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="oldpassword" class="col-md-4 col-sm-4 control-label">Current Password</label>

                            <div class="col-md-6 col-sm-6">
                                <input id="oldpassword" type="password" class="form-control" name="oldpassword" >


                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 col-sm-4 control-label">New Password</label>

                            <div class="col-md-6 col-sm-6">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 col-sm-4 control-label">Confirm Password</label>

                            <div class="col-md-6 col-sm-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aboutme" class="col-md-4 col-sm-4 control-label">About Me</label>

                            <div class="col-md-6 col-sm-6">
                                <textarea id="aboutme" class="form-control" name="aboutme" >{{$currentUser['info']}}</textarea>
                                @if ($errors->has('aboutme'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('aboutme') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-md-offset-4">
                                <button type="submit" name="save" value="Save" class="btn btn-primary">
                                    Save Changes
                                </button>
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
    $('textarea').on("change paste keyup",function() {
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
