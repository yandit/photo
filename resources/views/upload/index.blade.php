<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    <form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" accept="image/*" multiple>
        <button>Upload</button>
    </form>
</body>
</html>