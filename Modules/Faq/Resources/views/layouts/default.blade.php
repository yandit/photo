<!DOCTYPE html>
<html>
<head>
  @include('faq::partials.metadata')
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  @include('faq::partials.header')
  
  @include('usermanagement::admin.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('faq::partials.footer')
</div>
<!-- ./wrapper -->

@include('faq::partials.modal')
@include('faq::partials.scripts')
</body>
</html>
