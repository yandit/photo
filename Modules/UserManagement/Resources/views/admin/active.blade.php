
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Set Password</title>  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{{ asset('admin/dist/css/login.min.css') }}" rel="stylesheet" type="text/css" />    

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">

@if($message)
<div class="lockscreen-wrapper">
  <div class="text-center">
    <h3>{{ $message }}</h3>
  </div>
</div>
@else

<div class="login-box">  
  <!-- /.login-logo -->
  <div class="login-logo">
    SET PASSWORD
  </div>
  <div class="login-box-body">
    <p class="login-box-msg"></p>
    
    {!! Form::open(['route' => ['activate',$code], 'id'=>'form-activate']) !!}
      
      <div class="form-group has-feedback {{ ($errors->first('password')) ? 'has-error' : '' }}">
        <input id="password" type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}" minlength="6" required data-parsley-trigger="keyup focusout">        
        <span class="help-block">At least 6 characters, with number and text</span>
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
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Active Account</button>
        </div>
      </div>

    {!! Form::close() !!}    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endif

<script src="{{ asset('admin/dist/js/vendor.min.js') }}"></script>
<script>
  $('#form-activate').parsley({
    //successClass: "has-success",
    errorClass: "has-error",
    classHandler: function (el) {
      return el.$element.closest(".form-group");
    },
    errorsWrapper: "<span class='help-block'></span>",
    errorTemplate: "<span></span>"
  });
</script>
</body>
</html>
