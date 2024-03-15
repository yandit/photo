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
    @if(!in_array(Route::currentRouteName(), ['upload.index', 'list-image.index']))
      @include('partials.footer')
    @endif
    </div>
    <!-- ./wrapper -->

    @include('partials.scripts')
</body>
</html>
