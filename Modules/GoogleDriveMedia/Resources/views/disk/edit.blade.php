@extends('googledrivemedia::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Disk
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
                        <h3 class="box-title">Form Disk</h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    {!! Form::open(['route' => ['googledrivedisk.update', $disk->id], 'method' => 'PUT', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formGoogleDriveMedia']) !!}
                    <div class="box-body">
                        @if(in_array(loggedInUser('role')->slug, ['superadmin', 'admin']))
                        <div class="form-group {{ $errors->first('company') ? 'has-error' : '' }}">
                            <label for="fcompany">Company <span class="text-danger">*</span></label>
                            <select class="form-control" name="company" id="fcompany" required
                                data-parsley-trigger="keyup focusout">
                                <option value=""></option>
                                @foreach ($companies as $company)
                                    @php
                                        $selected = $company['id'] == old('company', $disk->company_id) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $company['id'] }}" {{ $selected }}>{{ $company['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('company'))
                                <span class="help-block">{{ $errors->first('company') }}</span>
                            @endif
                        </div>
                        @endif
                        <div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">
                            <label for="femail">Email</label>
                            <input type="text" class="form-control" id="femail" placeholder="Eamil"
                                name="email" value="{{ old('email', @$disk->email) }}"
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('email'))
                                <span class="help-block">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('password') ? 'has-error' : '' }}">
                            <label for="fpassword">Password</label>
                            <input type="password" class="form-control" id="fpassword" placeholder="Password"
                                name="password" value="{{ old('password', @$disk->password) }}"
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('disk_name') ? 'has-error' : '' }}">
                            <label for="fdisk_name">Disk Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fdisk_name" placeholder="Disk Name"
                                name="disk_name" value="{{ old('disk_name', $disk->disk_name) }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('disk_name'))
                                <span class="help-block">{{ $errors->first('disk_name') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('client_id') ? 'has-error' : '' }}">
                            <label for="fclient_id">Client Id <span class="text-danger">*</span></label>
                            <input type="text" name="client_id" class="form-control" id="fclient_id" rows="4" required
                                data-parsley-trigger="keyup focusout" value="{{ old('client_id', $disk->client_id) }}" placeholder="Client Id">
                            @if ($errors->has('client_id'))
                                <span class="help-block">{{ $errors->first('client_id') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('client_secret') ? 'has-error' : '' }}">
                            <label for="fclient_secret">Client Secret <span class="text-danger">*</span></label>
                            <input type="text" name="client_secret" class="form-control" id="fclient_secret" rows="4" required
                                data-parsley-trigger="keyup focusout" value="{{ old('client_secret', $disk->client_secret) }}" placeholder="Client Secret">
                            @if ($errors->has('client_secret'))
                                <span class="help-block">{{ $errors->first('client_secret') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('refresh_token') ? 'has-error' : '' }}">
                            <label for="frefresh_token">Refresh Token <span class="text-danger">*</span></label>
                            <input type="text" name="refresh_token" class="form-control" id="frefresh_token" rows="4" required
                                data-parsley-trigger="keyup focusout" value="{{ old('refresh_token', $disk->refresh_token) }}" placeholder="Refresh Token">
                            @if ($errors->has('refresh_token'))
                                <span class="help-block">{{ $errors->first('refresh_token') }}</span>
                            @endif
                        </div>

                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('googledrivedisk.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
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
                                    <td>: {{$disk->created_by->name}}</td>
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

    <script>
        $(document).ready(function(){
            handleShowHidePassowrd()
        })

        const handleShowHidePassowrd = function(){
            $("#fpassword").click(function () {
                var passwordField = $("#fpassword");
                var passwordFieldType = passwordField.attr("type");

                if (passwordFieldType === "password") {
                    passwordField.attr("type", "text");
                } else {
                    passwordField.attr("type", "password");
                }
            });
        }
    </script>
@endsection
