<!DOCTYPE html>
<html>
<head>
  @include('frames::partials.metadata')
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  @include('frames::partials.header')
  
  @include('usermanagement::admin.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('frames::partials.footer')
</div>
<!-- ./wrapper -->

@include('frames::partials.modal')
@include('frames::partials.scripts')
</body>
</html>
