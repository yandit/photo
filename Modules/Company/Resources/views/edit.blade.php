@extends('company::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Company
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Company</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    {!! Form::open(['route' => ['company.update', $company->id], 'method' => 'PUT', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formCompany']) !!}
                    <div class="box-body">

                        <div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
							<label for="femail">Email <span class="text-danger">*</span></label>
							<input readonly type="text" class="form-control" id="femail" placeholder="Email" name="email" value="{{ (old('email')) ? old('email') : $company->user->email }}">
							@if($errors->has('email'))										
								<span class="help-block">{{ $errors->first('email') }}</span>
							@endif
						</div>

                        <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
                            <label for="fname">Company <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fname" placeholder="Company" onkeyup="slugify(this,'#fslug')"
                                name="name" value="{{ old('name', $company->name) }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

						<div class="form-group {{ ($errors->first('phone')) ? 'has-error' : '' }}">
							<label for="fphone">Phone</label>
							<input type="number" class="form-control" id="fphone" placeholder="Phone" name="phone" value="{{ (old('phone')) ? old('phone') : $company->user->phone }}">
							@if($errors->has('phone'))
								<span class="help-block">{{ $errors->first('phone') }}</span>
							@endif
						</div>

						<div class="form-group {{ ($errors->first('address')) ? 'has-error' : '' }}">
							<label for="fphone">Address</label>
							<textarea name="address" class="form-control"  id="fphone" rows="5">{{ (old('address')) ? old('address') : $company->user->address }}</textarea>
							@if($errors->has('address'))
								<span class="help-block">{{ $errors->first('address') }}</span>
							@endif
						</div>

                        <div class="form-group {{ $errors->first('status') ? 'has-error' : '' }}">
                            <label for="fstatus">Status</label>
                            <select class="form-control" name="status" id="fstatus" required
                                data-parsley-trigger="keyup focusout">
                                <option value="">-- Select Option --</option>
                                @foreach (config('company.enable_disable') as $status)
                                    @php
                                        $selected = old('status', $company->status) == $status['value'] ? 'selected' : '';
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
                            <a href="{{ route('company.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
                            <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-save"></i> Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

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
                                    <td>: {{$company->created_by->name}}</td>
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
    @include('company::partials.script')
@endsection
