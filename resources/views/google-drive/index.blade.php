@extends('layouts.default')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('fe/google-drive/css/app.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('fe/google-drive/css/theme.css') }}">
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
			<div class="card-columns">
                @foreach ($all_files as $file)
                    @if (strpos($file['mimetype'], 'image') !== false)
                        
                        <div class="card card-pin">
                            <img class="card-img" src="{{ route('googledrive.get', ['disk_name'=> $file['disk_name'],'path' => $file['path']]) }}" alt="Card image">
                            <div class="overlay">
                                <h2 class="card-title title">Cool Title</h2>
                                <div class="more">
                                    <a href="post.html">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> More </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
    			
    		</div>
        </div>
    </div>
</section>
<!-- ***** Features Big Item End ***** -->


@endsection

@section('script')
@parent
<script>
    
</script>
@endsection