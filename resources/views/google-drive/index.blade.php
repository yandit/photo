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
    .btn-choose {
        position: fixed;
        bottom: 20px; 
        left: 50%;
        transform: translateX(-50%);
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 300px;
        z-index: 2;
        opacity: 0
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
<section class="section" id="about" style="z-index: 1;">
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
<a href="javascript:void(0)" id="submit" class="btn btn-primary btn-choose">Pilih Gambar</a>
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
        handleShowButton()
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
            // Mendapatkan data yang ada di local storage, jika ada
            const existingData = localStorage.getItem("gdrive_images");

            let dataImages = existingData ? JSON.parse(existingData) : [];
            const newObj = {
                path: path,
                disk: disk
            };
            dataImages.push(newObj);

            localStorage.setItem('gdrive_images', JSON.stringify(dataImages));
        }else{
            removeObjectByPath(path);
        }
        handleShowButton()
    }

    const handleShowButton = function(){
        if($('.select-image:checked').length){
            $(".btn-choose").animate({ opacity: 1 }, 300);
        }else{
            $(".btn-choose").animate({ opacity: 0 }, 300);
        }
    }

    const handleOnload = function(){
        // Set checked checkbox jika datanya ada di local storage
        $('.select-image').each(function() {
            const path = $(this).data('path')
            const disk = $(this).data('disk')
            const isChecked = isObjectWithPathExists(path);
            
            if (isChecked) {
                $(this).prop('checked', true);
            }
        });
    }

    const isObjectWithPathExists = function(path) {
        // Mendapatkan data yang ada di local storage, jika ada
        const existingData = localStorage.getItem("gdrive_images");

        // Jika tidak ada data sebelumnya atau data kosong, kembalikan false
        if (!existingData) {
            return false;
        }

        // Mengonversi data menjadi array
        const dataImages = JSON.parse(existingData);

        // Memeriksa apakah ada objek dengan ID yang sesuai di dalam array
        return dataImages.some(function(obj) {
            return obj.path === path;
        });
    }

    const removeObjectByPath = function(path) {
        // Mendapatkan data yang ada di local storage, jika ada
        const existingData = localStorage.getItem("gdrive_images");

        // Jika tidak ada data sebelumnya, tidak ada yang perlu dihapus
        if (!existingData) {
            return;
        }

        // Mengonversi data menjadi array
        let dataImages = JSON.parse(existingData);

        // Mencari indeks objek dengan ID yang sesuai di dalam array
        const indexToRemove = dataImages.findIndex(function(obj) {
            return obj.path === path;
        });

        // Jika objek dengan ID yang sesuai ditemukan, hapus objek tersebut dari array
        if (indexToRemove !== -1) {
            dataImages.splice(indexToRemove, 1);

            // Simpan array yang sudah diperbarui ke dalam local storage
            localStorage.setItem("gdrive_images", JSON.stringify(dataImages));
        }
    }

    const handleSelectImage = function(){
        // Ketika checkbox diubah, simpan statusnya ke local storage
        $('.select-image').on('change',function(e) {
            handleCheckbox(this)
        });
    }

    const handleSubmit = function(){
        $('#submit').click(function(){
            const existingData = localStorage.getItem('gdrive_images')

            if(!existingData){
                return false
            }

            const dataImages = JSON.parse(existingData);

            $('#loading-modal').modal('show');
            $.ajax({
                url: `${BASE_URL}/list-image/${SLUG}/store`,
                method: 'POST',
                data: {
                    'datas': dataImages
                },
                success: function(res){
                    if(res.status == 'success'){
                        localStorage.removeItem('gdrive_images');
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