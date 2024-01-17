@extends('layouts.default')
@section('metadata')
@parent
<link rel="stylesheet" href="{{ asset('fe/css/cropper.min.css') }}">
@endsection

@section('content')
<form action="{{ route('upload.store', ['slug'=> $slug]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" accept="image/*" multiple>
    <button>Upload</button>
    @foreach ($uploads as $upload)
    <div style="width: 300px; height: 300px">
        <img style="display: block; max-width: 100%" id="image" src="{{ $upload->image }}" alt="">
    </div>
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

@section('script')
@parent

<!-- https://github.com/fengyuanchen/cropperjs/blob/main/README.md -->
<script src="{{ asset('fe/js/cropper.min.js') }}"></script>

<script>
    $(document).ready(function(){
        const slug = "{{$slug}}"
        const session_whitelist = "{{$session_whitelist}}"
        if(slug && !session_whitelist){
            handlePromt()
        }

        handleCrop()
    })

    function handleCrop(){
        const image = document.getElementById('image');
        const cropper = new Cropper(image, {
            // aspectRatio: 1 / 1,
            autoCropArea: 1,
            guides: false,
            center: false,
            rotatable: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            dragMode: 'move',
            viewMode: 3,
            // minCropBoxWidth: 10,
            crop(event) {
                console.log('x '+event.detail.x);
                console.log('y '+event.detail.y);
                console.log('w '+event.detail.width);
                console.log('h '+event.detail.height);
                console.log(event.detail.rotate);
                console.log(event.detail.scaleX);
                console.log(event.detail.scaleY);
                console.log('========================')
            },
        });
    }

    function handlePromt(){
        var input = prompt("Please enter pin to access the photos:");

        if (input !== null) {
            // User clicked OK and entered some input
            console.log("User entered: " + input);
            $.ajax({
                url: `${BASE_URL}/pin-check`,
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'slug': slug,
                    'pin': input
                },
                success: function(res){
                    if(res.success){
                        alert(res.messages)
                        window.location.reload()
                    }else{
                        alert(res.messages)
                    }
                    
                }
            })
        } else {
            // User clicked Cancel
            console.log("User clicked Cancel");
        }
    }
</script>
@endsection