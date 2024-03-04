@section('script')
<script src="{{ asset('admin/dist/js/vendor.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/app.min.js') }}"></script>   
{{-- toastr --}}
<script>
  @if(Session::has('message'))
    toastr.success("{{session('message')}}", 'Success!');
  @endif

  @if(Session::has('error'))
    toastr.error("{{session('error')}}", 'Error!');
  @endif

  @if(Session::has('warning'))
    toastr.warning("{{session('warning')}}", 'Warning!');
  @endif

  @if(Session::has('info'))
    toastr.info("{{session('info')}}", 'Info!');
  @endif
</script>

<script>
  const ADMIN_URL = "{!! url(config('usermanagement.admin_prefix')) !!}";
  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });
</script>
@show