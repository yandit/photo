@extends('usermanagement::admin.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Profile
			<small></small>
		</h1>
		<ol class="breadcrumb">
			{{-- <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>User</li>
			<li><a href="{{ route('cms.admin.view') }}">Admin</a></li>			
			<li class="active">Profile</li> --}}
		</ol>
  </section>

  <section class="content">
    
    @include('usermanagement::admin.partials.flash')

    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"></h3>
          </div>
          <!-- /.box-header -->
					
					<!-- form start -->
					{!! Form::open(['route' => 'admin.profile_update', 'role'=>'form', 'autocomplete'=>'off', 'id'=>'formProfile']) !!}	
						<div class="box-body">
							
							<div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
								<label for="femail">Email</label>
								<input type="text" class="form-control" id="femail" placeholder="Email" name="email" value="{{ old('email', $user->email) }}" disabled>
              </div>
              
              <div class="form-group {{ ($errors->first('role')) ? 'has-error' : '' }}">
                <select name="role" class="form-control" id="frole" disabled>
                  <option value="">-- Select Option --</option>
                  @foreach($roles as $role)
                    @php
                      $selected = ( isset($user->role->id) && $role->id == $user->role->id) ? 'selected' : '';
                      if(old('role') && old('role')==$role->id){
                        $selected = 'selected';
                      }
                    @endphp
                    <option value="{{ $role->id }}" {{ $selected }}>{{ $role->name }}</option>
                  @endforeach
                </select>
                @if($errors->has('role'))										
                  <span class="help-block">{{ $errors->first('role') }}</span>
                @endif
              </div>

							<div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
								<label for="fname">Name</label>
								<input type="text" class="form-control" id="fname" placeholder="Name" name="name" value="{{ (old('name')) ? old('name') : $user->name }}" required data-parsley-trigger="keyup focusout">
								@if($errors->has('name'))										
									<span class="help-block">{{ $errors->first('name') }}</span>
								@endif
              </div>                          

              <p class="help-block">Isi kolom password apabila anda ingin mengubah password.</p>

              <div class="form-group {{ ($errors->first('password')) ? 'has-error' : '' }}">
								<label for="fpassword">Password</label>
								<input type="password" class="form-control" id="fpassword" placeholder="Password" name="password" value="{{ (old('password')) }}" 
                  data-parsley-trigger="keyup focusout" 
                  data-parsley-minlength="8"
                >
								@if($errors->has('password'))										
									<span class="help-block">{{ $errors->first('password') }}</span>
								@endif
              </div>                          

              <div class="form-group">
								<label> Repeat Password</label>
								<input type="password" class="form-control" placeholder="Repeat Password" id="frepeat_password" name="repeat_password" 
                  data-parsley-trigger="keyup focusout" 
                  data-parsley-equalto="#fpassword"
                  data-parsley-minlength="8"
                >
              </div>

						</div>
						<!-- /.box-body -->																		

						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>						
					{!! Form::close() !!}


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
  <script>
    $('#formProfile').parsley(parsleyOptions);
  </script>
@endsection