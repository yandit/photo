<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forgot Password</title>  
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
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:void(0)"><b>Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible auto-close-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-check"></i> {!! Session::get('message') !!} 
    </div>
    @endif
    
    {!! Form::open(['route' => 'admin.forgotpassword.submit']) !!}
      
      <div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        {{-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> --}}
        @if($errors->has('email'))
          <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
      </div>
      

      <div class="row">
        <div class="col-xs-8">          
        </div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block">Request new password</button>
        </div>
      </div>

    {!! Form::close() !!}
    <p style="margin-top: 5px">
        <a href="{{ route('admin.login') }}">Login</a><br>
    </p>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="{{ asset('admin/dist/js/login.min.js') }}"></script>
</body>
</html>
