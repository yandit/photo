@extends('googledrivemedia::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Credential
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Credential</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    {!! Form::open(['route' => ['googledrivecredential.update', $customer->id], 'method' => 'PUT', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formCredential']) !!}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="fname">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fname" placeholder="Name"
                                name="name" value="{{ $customer->name }}" disabled
                                data-parsley-trigger="keyup focusout">
                        </div>

                        <div class="form-group {{ $errors->first('path') ? 'has-error' : '' }}">
                            <label for="fpath">Path <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fpath" placeholder="Path"
                                name="path" value="{{ old('path', @$credential->path) }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('path'))
                                <span class="help-block">{{ $errors->first('path') }}</span>
                            @endif
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('googledrivecredential.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
                            <button type="submit" class="btn btn-warning"> <i class="glyphicon glyphicon-save"></i> Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->

            <div class="col-md-4">
                <div class="box box-warning">
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
                                    <td>: {{$customer->created_by->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Updated By</b></td>
                                    <td>: {{loggedInUser('name')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Updated At</b></td>
                                    <td>: {{date('d M Y')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>

@endsection

@section('script')
    @parent
    @include('googledrivemedia::partials.script')
@endsection
