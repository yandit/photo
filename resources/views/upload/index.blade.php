@extends('layouts.default')

@section('content')
<form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" accept="image/*" multiple>
    <button>Upload</button>
    @foreach ($uploads as $upload)
    <img width="100px" src="{{ $upload->image }}" alt="">
    @endforeach
</form>
@endsection