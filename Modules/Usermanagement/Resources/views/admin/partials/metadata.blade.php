@section('metadata')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>User Management</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('admin/dist/css/vendor.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/dist/css/app.min.css') }}" rel="stylesheet" type="text/css">

<!-- Google Font -->
<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@show