<!DOCTYPE html>
<html>
<head>
  @include('company::partials.metadata')
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  @include('company::partials.header')
  
  @include('usermanagement::admin.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('company::partials.footer')
</div>
<!-- ./wrapper -->

@include('company::partials.modal')
@include('company::partials.scripts')
</body>
</html>
