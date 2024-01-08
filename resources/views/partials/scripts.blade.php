@section('script')
<script src="{{ asset('admin/dist/js/vendor.min.js') }}"></script>
<script>
    const BASE_URL = "{!! url('') !!}";
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@show