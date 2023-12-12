<!DOCTYPE html>
<html>
<head>
  @include('partials.metadata')
</head>
<body>
    <div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('partials.footer')
    </div>
    <!-- ./wrapper -->

</body>
</html>
