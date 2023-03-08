
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reset Password</title>  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{{ asset('admin/dist/css/login.min.css') }}" rel="stylesheet" type="text/css" />    

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
@if($message)
<div class="lockscreen-wrapper">
  <div class="text-center">
    <h3>{!! $message !!}</h3>
  </div>
</div>
@else
<div class="login-box">  
  <!-- /.login-logo -->
  <div class="login-logo">
    RESET PASSWORD
  </div>
  <div class="login-box-body">
    <p class="login-box-msg"></p>
    {!! Form::open(['route' => ['admin.reset_password.submit',$code], 'id'=>'form-reset-password']) !!}
      
      <div class="form-group has-feedback {{ ($errors->first('password')) ? 'has-error' : '' }}">
        <input id="password" type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}" 
          minlength="6" 
          required 
          data-parsley-trigger="keyup focusout"
          data-parsley-number="1"
        >
        @if($errors->has('password'))          
          <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
      </div>

      <div class="form-group has-feedback {{ ($errors->first('password_confirmation')) ? 'has-error' : '' }}">
        <input id="password-confirmation" type="password" class="form-control" placeholder="Password Confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" 
          required data-parsley-trigger="keyup focusout" 
          data-parsley-equalto="#password"
          data-parsley-equalto-message="password confirmation not match">
        @if($errors->has('password_confirmation'))
        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
        @endif
      </div>

      <div class="row">
        <div class="col-xs-6">          
        </div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
        </div>
        <center>Or</center>
        <div class="col-xs-12">
          <a href="{{ route('admin.login') }}" class="btn btn-danger btn-block btn-flat">Login</a>
        </div>
      </div>

    {!! Form::close() !!}    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endif

<script src="{{ asset('admin/dist/js/vendor.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
<script>

  $('#form-reset-password').parsley(parsleyOptions);
</script>
</body>
</html>
