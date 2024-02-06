@extends('layouts.default')
@section('metadata')
@parent
<link rel="stylesheet" href="{{ asset('fe/css/cropper.min.css') }}">
<style>
    .image-container {
        position: relative;
        width: 296px; 
        height: 296px;
    }
    .classic-black-border {
        /* padding: 20px; */
        background-color: #fff;
        border: 15px solid transparent;
        border-image: 
            linear-gradient(45deg, #111, #111) 1;
        border-image-slice: 1;
        border-image-width: 15px; 
        border-image-outset: 0px; 
        border-radius: 10px;
        font-family: Arial, sans-serif;
        text-align: center;
        font-size: 18px;
        box-shadow: 5px 5px 40px rgba(0, 0, 0, 0.5);
    }

    .classic-black-border-right{
        position: absolute; 
        left: 288px; 
        top: 0px; 
        width: 8.84211px; 
        height: 292px; 
        clip-path: polygon(0px 0px, 100% 3.17101%, 100% 100%, 0px 95.999%); 
        background: rgb(88, 88, 88);
    }

    .classic-black-border-bottom{
        position: absolute; 
        left: 8px; 
        top: 280px; 
        width: 289px; 
        height: 11.7895px; 
        clip-path: polygon(0px 0px, 96.9027% 0px, 100% 100%, 2.39726% 100%); 
        background: rgb(66, 66, 66);
    }


    /* classic white */
    .classic-white-border {
        /* padding: 20px; */
        background-color: #fff;
        border: 15px solid transparent;
        border-image: 
            linear-gradient(45deg, #fff, #fff) 1;
        border-image-slice: 1;
        border-image-width: 15px; 
        border-image-outset: 0px; 
        border-radius: 10px;
        font-family: Arial, sans-serif;
        text-align: center;
        font-size: 18px;
        box-shadow: 5px 5px 40px rgba(0, 0, 0, 0.5);
    }

    .classic-white-border-right{
        position: absolute; 
        left: 288px; 
        top: 0px; 
        width: 8.84211px; 
        height: 292px; 
        clip-path: polygon(0px 0px, 100% 3.17101%, 100% 100%, 0px 95.999%); 
        background: rgb(160, 160, 160);
    }

    .classic-white-border-bottom{
        position: absolute; 
        left: 8px; 
        top: 280px; 
        width: 289px; 
        height: 11.7895px; 
        clip-path: polygon(0px 0px, 96.9027% 0px, 100% 100%, 2.39726% 100%); 
        background: rgb(100, 100, 100);
    }
    /* end classic white */
</style>
@endsection

@section('content')
<div>
    <ul>
    @foreach ($frames as $frame)
        <li>
            <a href="javascript:void(0)" data-class="{{ $frame->class }}" class="frame-selection">
                <img src="{{ Storage::url($frame->image) }}" style="width: 200px" alt="">
                <br>
                <span>{{$frame->title}}</span>
            </a>
        </li>
    @endforeach
    </ul>
    <form action="{{ route('upload.store', ['slug'=> $slug]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" accept="image/*" multiple>
        <button>Upload</button>
    </form>
    @foreach ($uploads as $upload)
    <div class="image-container">
        <div class="3d-border">
            <div class="border-right {{$selected_frame->class}}-border-right"></div>
            <div class="border-bottom {{$selected_frame->class}}-border-bottom"></div>
        </div>
        <div style="position: relative;" data-id="{{ $upload->id }}" class="m-2 img-list-container {{$selected_frame->class}}-border">
            

            <img style="max-width: 100%" class="img-lists" src="{{ route('getimage.crop', ['x'=> $upload->x ? $upload->x : 'null', 'y' => $upload->y ? $upload->y : 'null', 'w'=> $upload->width, 'h'=> $upload->height, 'path' => $upload->image, 'source' => $upload->source]) }}" alt="">

            <div style="position: absolute; bottom: 0; left: 0; right: 0; display: flex;" class="text-center">
                <div class="btn-crop" data-image="{{ $upload->source == 'local' ? Storage::url($upload->image) : $upload->image }}" 
                    data-cleft="{{ $upload->cleft }}" 
                    data-ctop="{{ $upload->ctop }}" 
                    data-cwidth="{{ $upload->cwidth }}" 
                    data-cheight="{{ $upload->cheight }}" 
                    style="flex: 1; background: rgba(255, 0, 0, 0.5);"
                >
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
                <button type="button" id="btn-crop-submit" class="btn btn-primary">Save changes</button>
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
    let cropper;
    let btn_crop;
    const modal = $('#modal-crop')

    $(document).ready(function(){
        
        const session_whitelist = "{{$session_whitelist}}"
        if(slug && !session_whitelist){
            handlePromt()
        }
        handleFrameSelection()
        handleInitCrop()
        handleCrop()
    })

    function handleFrameSelection(){
        $('.frame-selection').on('click', function(){
            const border_class = $(this).data('class')
            $('.image-container').each(function(){
                $(this).find('.3d-border .border-right').attr('class', `border-right ${border_class}-border-right`)
                $(this).find('.3d-border .border-bottom').attr('class', `border-bottom ${border_class}-border-bottom`)

                $(this).find('.img-list-container').attr('class', `m-2 img-list-container ${border_class}-border`)
            })
        });
    }

    function handleInitCrop(){
        $(document).on('click', '.btn-crop', function(){
            btn_crop = $(this)
            const image = $(this).data('image')
            
            const cleft = $(this).data('cleft')
            const ctop = $(this).data('ctop')
            const cwidth = $(this).data('cwidth')
            const cheight = $(this).data('cheight')
            
            modal.find('.modal-body').html(`
                <div style="width: 250px; height: 250px;" class="mx-auto">
                    <img style="max-width: 100%; display: block" src="${image}" id="cropped-image" alt="">
                </div>
            `)

            let cropped_image = document.getElementById('cropped-image');

            let canvas_data;
		    let cropbox_data;

            cropped_image.addEventListener('ready', function(){
                canvas_data = cropper.getCanvasData();
                cropbox_data = cropper.getCropBoxData();
                
                canvas_data.left = (cleft) ? parseFloat(cleft) : '';
                canvas_data.top = (ctop) ? parseFloat(ctop) : '';
                canvas_data.width = (cwidth) ? parseFloat(cwidth) : '';
                canvas_data.height = (cheight) ? parseFloat(cheight) : '';

                cropper.setCropBoxData(cropbox_data).setCanvasData(canvas_data);
            })

            cropper = new Cropper(cropped_image, {
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
            });

            

            modal.modal('show')
        })
    }

    function handleCrop(){
        $(document).on('click', '#btn-crop-submit', function(){
            const cropped_data = cropper.getData()
            const c_data = cropper.getCanvasData();

            const x = cropped_data.x
            const y = cropped_data.y
            const width = cropped_data.width
            const height = cropped_data.height

            btn_crop.data('cleft', c_data.left)
            btn_crop.data('ctop', c_data.top)
            btn_crop.data('cwidth', c_data.width)
            btn_crop.data('cheight', c_data.height)

            const cropped_image = cropper.getCroppedCanvas({width: 250, height: 250}).toDataURL('image/jpeg')
            const img_list_container = btn_crop.closest('.img-list-container')

            const upload_id = img_list_container.data('id')
            
            $.ajax({
                url: `/upload/edit/${upload_id}`,
                type: 'PUT',
                data: {
                    'x': x,
                    'y': y,
                    'w': width,
                    'h': height,
                    'cwidth': c_data.width,
                    'cheight': c_data.height,
                    'cleft': c_data.left,
                    'ctop': c_data.top,
                },
                success: function(res){
                    if (!res.success){
                        alert(res.message)
                        return false
                    }
                    
                    modal.modal('hide')
                    img_list_container.find('img').attr('src', cropped_image)
                }
            })

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