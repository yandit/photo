@extends('usermanagement::admin.layouts.default')

@section('content')
	<section class="content-header">
		<h1>
			Edit Admin
			<small></small>
		</h1>
		<ol class="breadcrumb">
			{{-- <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>User</li>
			<li><a href="{{ route('cms.admin.view') }}">Admin</a></li>			
			<li class="active">Edit</li> --}}
		</ol>
	</section>

	<!-- Main content -->
  <section class="content">
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
						{!! Form::open(['route' => ['admin.update', $user->id], 'method'=>'PUT', 'role'=>'form', 'autocomplete'=>'off', 'id'=>'formAdmin']) !!}
							<div class="box-body">
							
								<div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
									<label for="femail">Email <span class="text-danger">*</span></label>
									<input readonly type="text" class="form-control" id="femail" placeholder="Email" name="email" value="{{ (old('email')) ? old('email') : $user->email }}">
									@if($errors->has('email'))										
										<span class="help-block">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
									<label for="fname">Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="fname" placeholder="Name" name="name" value="{{ (old('name')) ? old('name') : $user->name }}" required data-parsley-trigger="keyup focusout">
									@if($errors->has('name'))										
										<span class="help-block">{{ $errors->first('name') }}</span>
									@endif
								</div>

								<div class="form-group {{ ($errors->first('role')) ? 'has-error' : '' }}">
									<label for="frole">Role <span class="text-danger">*</span></label>
									<select name="role" class="form-control" id="frole" required data-parsley-trigger="keyup focusout">
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

								<div class="form-group {{ ($errors->first('phone')) ? 'has-error' : '' }}">
									<label for="fphone">Phone</label>
									<input type="number" class="form-control" id="fphone" placeholder="Phone" name="phone" value="{{ (old('phone')) ? old('phone') : $user->phone }}">
									@if($errors->has('phone'))
										<span class="help-block">{{ $errors->first('phone') }}</span>
									@endif
								</div>
	
								<div class="form-group {{ ($errors->first('address')) ? 'has-error' : '' }}">
									<label for="fphone">Address</label>
									<textarea name="address" class="form-control"  id="fphone" rows="5">{{ (old('address')) ? old('address') : $user->address }}</textarea>
									@if($errors->has('address'))
										<span class="help-block">{{ $errors->first('address') }}</span>
									@endif
								</div>
							</div>
							<!-- /.box-body -->																		

							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
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
    $('#formAdmin').parsley(parsleyOptions);
	$('#frole').change(function(){
		var printPartnerExtra = $('#printPartnerExtra');
		var selectedSlug = $(this).find(':selected').data('slug');
		if(selectedSlug=='print-partner'){
			printPartnerExtra.show();
			$('input[name^="print_partner_"]').prop('required',true);
		}else{
			printPartnerExtra.hide();
			$('input[name^="print_partner_"]').prop('required',false);
		}
	});
  </script>
@endsection