@extends('layouts.default')
@section('metadata')
@parent
<style>
    body{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        /* background-color: rgb(0, 0, 34); */
        font-size: 0.8rem;
    }
    .card{
        /* max-width: 1000px; */
        margin: 2vh;
    }
    .card-top{
        padding: 0.7rem 5rem;
    }
    .card-top a{
        float: left;
        margin-top: 0.7rem;
    }
    #logo{
        font-family: 'Dancing Script';
        font-weight: bold;
        font-size: 1.6rem;
    }
    .card-body{
        padding: 0 5rem 5rem 5rem;
        /* background-image: url("https://i.imgur.com/4bg1e6u.jpg"); */
        background-size: cover;
        background-repeat: no-repeat;
    }
    @media(max-width:768px){
        .card-body{
            padding: 0 1rem 1rem 1rem;
            /* background-image: url("https://i.imgur.com/4bg1e6u.jpg"); */
            background-size: cover;
            background-repeat: no-repeat;
        }  
        .card-top{
            padding: 0.7rem 1rem;
        }
    }
    .row{
        margin: 0;
    }
    .upper{
        padding: 1rem 0;
        justify-content: space-evenly;
    }
    .page-number{
        border-radius: 1rem;
            width: 22px;
        height: 22px;
        margin-right:3px;
        border: 1px solid blue;
        text-align: center;
        display: inline-block;
    }
    .page-title{
        margin:0;
        color: blue;
    }
    .icons{
        margin-left: auto;
    }
    form span{
        color: rgb(179, 179, 179);
    }
    form{
        padding: 2vh 0;
    }
    input, textarea{
        border: 1px solid rgba(0, 0, 0, 0.137);
        padding: 1vh;
        margin-bottom: 4vh;
        outline: none;
        width: 100%;
        background-color: rgb(247, 247, 247);
    }
    input:focus::-webkit-input-placeholder
    {
        color:transparent;
    }
    textarea:focus::-webkit-input-placeholder
    {
        color:transparent;
    }
    .header{
        font-size: 1.5rem;
    }
    .left{
        background-color: #ffffff;
        padding: 2vh;   
    }
    .left img{
        width: 2rem;
    }
    .left .col-4{
        padding-left: 0;
    }
    .right .item{
        padding: 0.3rem 0;
    }
    .right{
        background-color: #ffffff;
        padding: 2vh;
    }
    .col-8{
        padding: 0 1vh;
    }
    .lower{
        line-height: 2;
    }
    .btn{
        background-color: rgb(23, 4, 189);
        border-color: rgb(23, 4, 189);
        color: white;
        width: 100%;
        font-size: 0.7rem;
        margin: 4vh 0 1.5vh 0;
        padding: 1.5vh;
        border-radius: 0;
    }
    .btn:focus{
        box-shadow: none;
        outline: none;
        box-shadow: none;
        color: white;
        -webkit-box-shadow: none;
        -webkit-user-select: none;
        transition: none; 
    }
    .btn:hover{
        color: white;
    }
    a{
        color: black;
    }
    a:hover{
        color: black;
        text-decoration: none;
    }
    input[type=checkbox]{
        width: unset;
        margin-bottom: unset;
    }
    #cvv{
        background-image: linear-gradient(to left, rgba(255, 255, 255, 0.575) , rgba(255, 255, 255, 0.541)), url("https://img.icons8.com/material-outlined/24/000000/help.png");
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: center;
    } 
    #cvv:hover{

    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-top border-bottom text-center">
        <a href="{{ route('upload.index', ['slug'=> $slug]) }}"> <i class="fa fa-arrow-left"></i> Kembali ke upload page</a>
        <span id="logo">Checkout</span>
    </div>
    <div class="card-body">
        <div class="row upper">
            <!-- <span><i class="fa fa-check-circle-o"></i> Shopping bag</span> -->
            <span class="page-title"><span class="page-number">1</span>Detail Pesanan</span>
            <span class="page-title"><span class="page-number">2</span>Pembayaran</span>
        </div>
        <form action="" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <div class="left border">
                        <div class="row">
                            <span class="header">Detail Pemesan</span>
                        </div>
                        
                        <span>Nama:</span>
                        <input name="name" placeholder="Alexander" value="{{ old('name', @$cart->cart_checkout->name) }}">
                        <span>Email:</span>
                        <input name="email" placeholder="example@mail.com" value="{{ old('email', @$cart->cart_checkout->email) }}">
                        <span>Alamat:</span>
                        <textarea name="address" placeholder="Jl. jalan">{{ old('address', @$cart->cart_checkout->address) }}</textarea>
                        
                    </div>                        
                </div>
                <div class="col-md-5">
                    <div class="right border">
                        <div class="header">Rincian Pesanan</div>
                        <p>{{count($cart->uploads)}} items</p>
                        <div class="row item">
                            <div class="col-4 align-self-center"><img class="img-fluid" src="{{ route('getimage.crop', ['x'=> $cart->uploads->first()->x != null ? $cart->uploads->first()->x : 'null', 'y' => $cart->uploads->first()->y != null ? $cart->uploads->first()->y : 'null', 'w'=> $cart->uploads->first()->width, 'h'=> $cart->uploads->first()->height, 'path' => $cart->uploads->first()->image, 'source' => $cart->uploads->first()->source, 'disk'=> 'google']) }}"></div>
                            <div class="col-8">
                                <div class="row"><b>Rp. {{$totalPrice}}</b></div>
                                <div class="row text-muted">{{ $cart->frames_stickable->title }}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row lower">
                            <div class="col text-left">Subtotal</div>
                            <div class="col text-right">Rp. {{$totalPrice}}</div>
                        </div>
                        <div class="row lower">
                            <div class="col text-left">Ongkir</div>
                            <div class="col text-right">Gratis</div>
                        </div>
                        <div class="row lower">
                            <div class="col text-left"><a href="#"><u>Masukkan code voucher</u></a></div>
                        </div>
                        <div class="row lower">
                            <div class="col text-left"><b>Total Pembayaran</b></div>
                            <div class="col text-right"><b>Rp. 350.000</b></div>
                        </div>
                        <button class="btn">Pembayaran</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
    <div>
    </div>
</div>
@endsection