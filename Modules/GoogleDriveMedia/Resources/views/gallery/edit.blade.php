@extends('googledrivemedia::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Gallery
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Gallery</h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <div class="box-body">
                    <div class="text-center" style="margin-bottom: 30px">
                        <a class="btn btn-sm btn-warning" href="{{ route('googledrivegallery.create', ['credential'=> $credential]) }}" role="button"><i class="fa fa-plus"></i> Add Image</a>
                    </div>
                        <div class="row">
                        @foreach($all_files as $file)
                            @if (strpos($file['mimetype'], 'image') !== false)
                                <div class="col-md-3" style="height: 200px !important; position: relative; margin-bottom: 20px">
                                    <img width="100%" src="{{ route('get.image', ['disk_name' => $file['disk_name'], 'path' => $file['path']]) }}" alt="{{ $file['basename'] }}">
                                    <div style="position: absolute; bottom: 0px">
                                        <a href="{{ route('googledrivegallery.delete', ['credential'=> $credential, 'disk_name'=>$file['disk_name'], 'path'=> $file['path']]) }}">delete</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('googledrivegallery.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                    </div>

                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->

        </div>
        <!-- /.row -->
    </section>

@endsection

@section('script')
    @parent
    @include('googledrivemedia::partials.script')

    <script>
        $(document).ready(function(){
            
        })

        
    </script>
@endsection
