@section('script')
<!-- jQuery -->
<script src="{{ asset('fe/js/jquery-2.1.0.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('fe/js/popper.js') }}"></script>
<script src="{{ asset('fe/js/bootstrap.min.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('fe/js/owl-carousel.js') }}"></script>
<script src="{{ asset('fe/js/scrollreveal.min.js') }}"></script>
<script src="{{ asset('fe/js/waypoints.min.js') }}"></script>
<script src="{{ asset('fe/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('fe/js/imgfix.min.js') }}"></script>

<!-- Global Init -->
<script src="{{ asset('fe/js/custom.js') }}"></script>

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