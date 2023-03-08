@section('script')
<script src="{{ asset('admin/dist/js/vendor.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/app.min.js') }}"></script>   
<script>
  const ADMIN_URL = "{!! url('admin') !!}";
  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });
</script>
@show