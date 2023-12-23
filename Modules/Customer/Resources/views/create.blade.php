@extends('customer::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create Customer
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            {!! Form::open(['route' => 'customer.store', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formCustomer']) !!}
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Customer</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    
                    <div class="box-body">

                        <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
                            <label for="fname">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fname" placeholder="Name" onkeyup="slugify(this,'#fslug')"
                                name="name" value="{{ old('name') }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('slug') ? 'has-error' : '' }}">
                            <label for="fslug">Slug <span class="text-danger">*</span></label>                  
                            <input type="text" class="form-control" id="fslug" placeholder="Slug" name="slug" value="{{ old('slug') }}" onkeypress="slugFormat(event)"
                                required data-parsley-trigger="keyup focusout">
                            @if($errors->has('slug'))										
                                <span class="help-block">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>                

                        <div class="form-group {{ $errors->first('status') ? 'has-error' : '' }}">
                            <label for="fstatus">Status</label>
                            <select class="form-control" name="status" id="fstatus" required
                                data-parsley-trigger="keyup focusout">
                                <option value="">-- Select Option --</option>
                                @foreach (config('customer.enable_disable') as $status)
                                    @php
                                        $selected = $status['value'] == 'enable' ? 'selected' : '';
                                        if (old('status') == $status['value']) {
                                            $selected = 'selected';
                                        }
                                    @endphp
                                    <option value="{{ $status['value'] }}" {{ $selected }}>{{ $status['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('status'))
                                <span class="help-block">{{ $errors->first('status') }}</span>
                            @endif
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('customer.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
                            <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-save"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
            <div class="col-md-4">
                <div class="box box-success">
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
    @include('customer::partials.script')
@endsection
