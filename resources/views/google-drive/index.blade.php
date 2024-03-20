@extends('layouts.default')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('fe/google-drive/css/app.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('fe/google-drive/css/theme.css') }}">
<style>
    .card-pin {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .select-image {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1;
        opacity: 0.5;
        cursor: pointer;
        width: 20px;
        height: 20px;
    }
</style>
@endsection

@section('content')
<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->


<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        MEMORAPIX
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <!-- <ul class="nav">
                        <li class="scroll-to-section"><a href="#welcome" class="menu-item">Home</a></li>
                        <li class="scroll-to-section"><a href="#about" class="menu-item">About</a></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a> -->
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->

<!-- ***** Features Big Item Start ***** -->
<section class="section" id="about">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card text-white bg-danger mb-3" style="width: 100%">
                    <div class="card-header">Info</div>
                    <div class="card-body">
                        <h5 class="card-title">Success card title</h5>
                        <span class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. <br> <a class="text-light" href="{{ route('upload.index', ['slug'=> $slug]) }}">klik untuk upload foto</a></span>
                    </div>
                </div>
            </div>
			<div class="col-12 card-columns">
                @foreach ($all_files as $file)
                    @if (strpos($file['mimetype'], 'image') !== false)
                        
                        <div class="card card-pin">
                            <input type="checkbox" class="select-image" data-path="{{ $file['path'] }}" data-disk="{{ $file['disk_name'] }}">
                            <img class="card-img" src="{{ route('googledrive.get', ['disk_name'=> $file['disk_name'],'path' => $file['path']]) }}" alt="Card image">
                            <div class="overlay">
                                <div class="more">
                                    <a href="post.html">
                                    <i class="fa fa-search-plus" aria-hidden="true" style="z-index: 5"></i> Zoom </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
    			
    		</div>
        </div>
    </div>
</section>
<div class="modal" id="loading-modal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <!-- Animasi loading -->
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0)" id="submit" class="btn btn-primary">Choose</a>
<!-- ***** Features Big Item End ***** -->


@endsection

@section('script')
@parent
<script>
    const SLUG = "{{$slug}}"
    $(document).ready(function(){
        handleOnload()
        handleSelectImage()
        handleSubmit()
        handleCheckboxClickPhoto()
    })

    const handleCheckboxClickPhoto = function(){
        $('.card-pin .overlay').on('click', function(event){
            if ($(event.target).is('a')) {
                // Jika elemen yang diklik adalah elemen <a>, hentikan penyebaran event
                event.stopPropagation();
            }else{
                // Mengambil checkbox terkait
                const checkbox = $(this).siblings('.select-image');
                $(checkbox).prop('checked', !$(checkbox).is(':checked'));
                handleCheckbox(checkbox)
            }
        });
    }

    const handleCheckbox = function(checkbox){
        const path = $(checkbox).data('path')
        const disk = $(checkbox).data('disk')
        // Toggle status centang checkbox

        if($(checkbox).is(':checked')){
            const dataObj = {
                path: path,
                disk: disk
            };
            localStorage.setItem(path, JSON.stringify(dataObj));
        }else{
            localStorage.removeItem(path);
        }
    }

    const handleOnload = function(){
        // Set checked checkbox jika datanya ada di local storage
        $('.select-image').each(function() {
            const path = $(this).data('path')
            const disk = $(this).data('disk')
            var isChecked = localStorage.getItem(path);
            
            if (isChecked) {
                $(this).prop('checked', true);
            }
        });
    }

    const handleSelectImage = function(){
        // Ketika checkbox diubah, simpan statusnya ke local storage
        $('.select-image').on('change',function(e) {
            handleCheckbox(this)
        });
    }

    const handleSubmit = function(){
        $('#submit').click(function(){
            // Array untuk menyimpan semua data dari local storage
            var localStorageDataArray = [];

            // Loop melalui semua item di local storage
            for (var i = 0; i < localStorage.length; i++) {
                var key = localStorage.key(i);
                var value = localStorage.getItem(key);
                var parsedValue = JSON.parse(value);

                // Menambahkan data ke array
                localStorageDataArray.push({
                    path: parsedValue.path,
                    disk: parsedValue.disk
                });
            }

            $('#loading-modal').modal('show');
            $.ajax({
                url: `${BASE_URL}/list-image/${SLUG}/store`,
                method: 'POST',
                data: {
                    'datas': localStorageDataArray
                },
                success: function(res){
                    if(res.status == 'success'){
                        localStorage.clear();
                        window.location.href = res.redirect;
                    }
                },
                finally: function(){
                    $('#loading-modal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            })
        })
    }
</script>
@endsection