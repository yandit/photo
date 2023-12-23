@extends('layouts.default')

@section('content')
<form action="{{ route('upload.store', ['slug'=> $slug]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" accept="image/*" multiple>
    <button>Upload</button>
    @foreach ($uploads as $upload)
    <img width="100px" src="{{ $upload->image }}" alt="">
    @endforeach
    <br>
    ==============================
    <br>
    <ul>
        @foreach ($all_files as $file)
            @if (strpos($file['mimetype'], 'image') !== false)
                <li>
                    <img width="100px" src="{{ route('googledrive.get', ['disk_name'=> $file['disk_name'],'path' => $file['path']]) }}" alt="{{ $file['basename'] }}">
                </li>
            @endif
        @endforeach
    </ul>
</form>
@endsection