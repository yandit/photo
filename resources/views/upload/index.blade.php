@extends('layouts.default')
@section('metadata')
@parent
<link rel="stylesheet" href="{{ asset('fe/css/cropper.min.css') }}">
@endsection

@section('content')
<div>
    <form action="{{ route('upload.store', ['slug'=> $slug]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" accept="image/*" multiple>
        <button>Upload</button>
    </form>
    @foreach ($uploads as $upload)
    <div style="width: 250px; height: 250px; position: relative" class="mb-2">

        <img style="max-width: 100%" src="{{ route('getimage.crop', ['x'=> $upload->x ? $upload->x : 'null', 'y' => $upload->y ? $upload->y : 'null', 'w'=> $upload->width, 'h'=> $upload->height, 'path' => $upload->image, 'source' => $upload->source]) }}" alt="">

        <div style="position: absolute; bottom: 0; left: 0; right: 0; display: flex;" class="text-center">
            <div class="btn-crop" data-image="{{ Storage::url($upload->image) }}" data-x="{{ $upload->x }}" data-y="{{ $upload->y }}" data-w="{{ $upload->width }}" data-h="{{ $upload->height }}" style="flex: 1; background: rgba(255, 0, 0, 0.5);">
                <a href="javascript:void(0)">crop</i></a>
            </div>
            <div style="flex: 1; background: rgba(255, 0, 0, 0.5);">
                <form action="{{ route('upload.destroy', ['upload' => $upload->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit">Delete</button>
                </form>
            </div>
        </div>
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
</div>

<!-- The Modal -->
<div class="modal" id="modal-crop">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Title</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
@parent

<!-- https://github.com/fengyuanchen/cropperjs/blob/main/README.md -->
<script src="{{ asset('fe/js/cropper.min.js') }}"></script>

<script>
    const slug = "{{$slug}}"
    $(document).ready(function(){
        
        const session_whitelist = "{{$session_whitelist}}"
        if(slug && !session_whitelist){
            handlePromt()
        }

        handleCrop()
    })

    function handleCrop(){
        $(document).on('click', '.btn-crop', function(){
            const image = $(this).data('image')
            // console.log(image)
            const x = $(this).data('x')
            const y = $(this).data('y')
            const w = $(this).data('w')
            const h = $(this).data('h')

            const modal = $('#modal-crop')
            
            modal.find('.modal-body').html(`
                <div style="width: 250px; height: 250px;" class="mx-auto">
                    <img style="max-width: 100%; display: block" src="${image}" id="cropped-image" alt="">
                </div>
            `)

            let cropped_image = document.getElementById('cropped-image');
            console.log(cropped_image)
            
            let cropper = new Cropper(cropped_image, {
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
                }
            });

            modal.modal('show')
        })
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