@extends('googledrivemedia::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Image
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            {!! Form::open(['route' => ['googledrivegallery.store', 'credential'=> $credential], 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formGoogleDriveMedia', 'enctype' => 'multipart/form-data']) !!}
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Image</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    
                    <div class="box-body">

                        <div class="form-group {{ $errors->first('image') ? 'has-error' : '' }}">
                            <label for="fimage">Image <span class="text-danger">*</span></label>
                            <input type="file" accept="image/*" multiple class="form-control" id="fimage" placeholder="Image"
                                name="image[]" value="{{ old('image') }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('image'))
                                <span class="help-block">{{ $errors->first('image') }}</span>
                            @endif
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('googledrivegallery.edit', ['credential'=> $credential]) }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
                            <button type="submit" class="btn btn-danger"> <i class="glyphicon glyphicon-save"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Information</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    
                    
                    <div class="box-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><b>Created By</b></td>
                                    <td>: {{loggedInUser('name')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Created At</b></td>
                                    <td>: {{date('d M Y')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
    </section>

@endsection

@section('script')
    @parent
    @include('faq::partials.script')
@endsection
