@extends('layouts.default')

@section('content')
<div class="row align-items-center" style="height: 100vh;"> 
    <div class="col-6 mx-auto">
        <div class="card shadow">
            <form action="" method="POST">
                @csrf
                <div class="card-body">
                    <h4 class="card-title text-center">Input your PIN</h4>
                    <!-- Input inline -->
                    <div class="d-flex justify-content-center">
                        <input type="password" name="pin[]" class="form-control mr-2 text-center input-pin" style="width: 50px; height: 50px; font-size:40px" autofocus="true" maxlength="1" required>
                        <input type="password" name="pin[]" class="form-control mr-2 text-center input-pin" style="width: 50px; height: 50px; font-size:40px" maxlength="1" required>
                        <input type="password" name="pin[]" class="form-control mr-2 text-center input-pin" style="width: 50px; height: 50px; font-size:40px" maxlength="1" required>
                        <input type="password" name="pin[]" class="form-control mr-2 text-center input-pin" style="width: 50px; height: 50px; font-size:40px" maxlength="1" required>
                        <input type="password" name="pin[]" class="form-control mr-2 text-center input-pin" style="width: 50px; height: 50px; font-size:40px" maxlength="1" required>
                        <input type="password" name="pin[]" class="form-control text-center input-pin" style="width: 50px; height: 50px; font-size:40px" maxlength="1" required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary mt-5">Lanjutkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
@parent
<script>
    $(document).ready(function() {

        $('.input-pin').keyup(function() {
            if (this.value.length === 1) {
                $(this).next('.input-pin').focus();
            }
        });
    });
</script>
@endsection