<!DOCTYPE html>
<html>
<head>
  @include('customer::partials.metadata')
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  @include('customer::partials.header')
  
  @include('usermanagement::admin.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('customer::partials.footer')
</div>
<!-- ./wrapper -->

@include('customer::partials.modal')
@include('customer::partials.scripts')
</body>
</html>
