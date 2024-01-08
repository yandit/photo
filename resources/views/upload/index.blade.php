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

@section('script')
@parent
<script>
    const slug = "{{$slug}}"
    const session_whitelist = "{{$session_whitelist}}"
    console.log(BASE_URL)
    if(slug && !session_whitelist){
        handlePromt()
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