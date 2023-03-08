<!DOCTYPE html>
<html>
<head>
  @include('usermanagement::admin.partials.metadata')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('usermanagement::admin.partials.header')
  
  @include('usermanagement::admin.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('usermanagement::admin.partials.footer')
</div>
<!-- ./wrapper -->

@include('usermanagement::admin.partials.modal')
@include('usermanagement::admin.partials.scripts')
</body>
</html>
