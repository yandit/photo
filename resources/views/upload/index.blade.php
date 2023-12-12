@extends('layouts.default')

@section('content')
<form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" accept="image/*" multiple>
    <button>Upload</button>
</form>
@endsection