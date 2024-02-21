@section('metadata')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Title</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" type="text/css" href="{{ asset('fe/css/bootstrap.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('fe/css/font-awesome.css') }}">

<link rel="stylesheet" href="{{ asset('fe/css/templatemo-lava.css') }}">

<link rel="stylesheet" href="{{ asset('fe/css/owl-carousel.css') }}">
@yield('styles')

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
@show