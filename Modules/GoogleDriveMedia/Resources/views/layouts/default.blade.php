<!DOCTYPE html>
<html>
<head>
  @include('googledrivemedia::partials.metadata')
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">

  @include('googledrivemedia::partials.header')
  
  @include('usermanagement::admin.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('googledrivemedia::partials.footer')
</div>
<!-- ./wrapper -->

@include('googledrivemedia::partials.modal')
@include('googledrivemedia::partials.scripts')
</body>
</html>
