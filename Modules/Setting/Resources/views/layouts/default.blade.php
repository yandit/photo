<!DOCTYPE html>
<html>
<head>
  @include('setting::partials.metadata')
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  @include('setting::partials.header')
  
  @include('setting::partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('setting::partials.footer')
</div>
<!-- ./wrapper -->

@include('setting::partials.modal')
@include('setting::partials.scripts')
</body>
</html>
