@extends('usermanagement::admin.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit Role
      <small></small>
    </h1>
    <ol class="breadcrumb">
      {{-- <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>User</li>
      <li><a href="{{ route('role.view') }}">Roles</a></li> --}}
      {{-- <li class="active">User</li> --}}
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- form start -->          
      {!! Form::open(['route' => ['role.update', $role->id], 'method'=>'PUT', 'role'=>'form', 'autocomplete'=>'off', 'id'=>'formRole']) !!}
      <!-- left column -->
      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Form Role</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <!-- /.box-header -->

            <div class="box-body">
              <div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
                <label for="fname">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="fname" placeholder="Name" name="name" value="{{ (old('name')) ? old('name') : $role->name }}" onkeyup="slugify(this,'#fslug')"
                  required data-parsley-trigger="keyup focusout">
								@if($errors->has('name'))										
									<span class="help-block">{{ $errors->first('name') }}</span>
								@endif
              </div>
              <div class="form-group">
                <label for="fslug">Slug <span class="text-danger">*</span></label>                  
                <input type="text" class="form-control" id="fslug" placeholder="Slug" name="slug" value="{{ (old('slug')) ? old('slug') : $role->slug }}" onkeypress="slugFormat(event)"
                  required data-parsley-trigger="keyup focusout">
                @if($errors->has('slug'))										
									<span class="help-block">{{ $errors->first('slug') }}</span>
								@endif
              </div>                
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <div class="pull-right">
                <a href="{{ route('role.index') }}" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i> Back</a>
                <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-save"></i> Submit</button>
              </div>
            </div>

        </div>
        <!-- /.box -->
      </div>
      <!--/.col (left) -->  
      {!! Form::close() !!}    
      
      <div class="col-md-4">
        <div class="box box-primary">
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
                            <td>: {{@$role->created_by->name}}</td>
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
  <script>
    $('#formRole').parsley(parsleyOptions);
  </script>
@endsection