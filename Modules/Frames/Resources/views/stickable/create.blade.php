@extends('frames::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create Stickable Frame
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            {!! Form::open(['route' => 'stickableframe.store', 'role' => 'form', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data', 'id' => 'formFrames']) !!}
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Stickable Frame</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    
                    <div class="box-body">                                        

                        <div class="form-group {{ ($errors->first('title')) ? 'has-error' : '' }}">
                          <label for="ftitle">Title <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="ftitle" placeholder="Title" name="title" 
                            value="{{ old('title') }}" required
                            onkeyup="slugify(this,'#fslug')"
                            data-parsley-trigger="keyup focusout">
                                          @if($errors->has('title'))										
                                              <span class="help-block">{{ $errors->first('title') }}</span>
                                          @endif
                        </div>
          
                        <div class="form-group {{ ($errors->first('slug')) ? 'has-error' : '' }}">
                          <label for="fslug">Slug <span class="text-danger">*</span></label>                  
                          <input type="text" class="form-control" id="fslug" placeholder="Slug" name="slug" value="{{ old('slug') }}" required 
                            data-parsley-trigger="keyup focusout"
                            onkeypress="slugFormat(event)">
                          @if($errors->has('slug'))										
                                              <span class="help-block">{{ $errors->first('slug') }}</span>
                                          @endif
                        </div>
          
                        <div class="form-group {{ ($errors->first('class')) ? 'has-error' : '' }}">
                          <label for="fclass">Css Class <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="fclass" placeholder="Css Class" name="class" 
                            value="{{ old('class') }}" required
                            data-parsley-trigger="keyup focusout">
                                          @if($errors->has('class'))										
                                              <span class="help-block">{{ $errors->first('class') }}</span>
                                          @endif
                        </div>
          
          
                        <div class="form-group {{ ($errors->first('image')) ? 'has-error' : '' }}">
                          <label for="fimage">Image <span class="text-danger">*</span></label>                  
                          <input type="file" class="form-control" id="fimage" name="image" accept="image/*"
                            onchange="previewImage(this, '#image')"
                            data-parsley-trigger="keyup focusout">
                          <div style="margin-top: 5px; display: none;">                          
                            <img src="" alt="setting" height="100" id="image">
                          </div>
                          @if($errors->has('image'))                    
                            <span class="help-block">{{ $errors->first('image') }}</span>
                          @endif
                        </div>
          
                        <div class="form-group {{ ($errors->first('order')) ? 'has-error' : '' }}" >
                          <label for="forder">Order <span class="text-danger">*</span></label>                  
                          <input type="numeric" class="form-control input-price" id="forder" placeholder="Order" name="order" 
                            value="{{ old('order') }}" 
                            data-parsley-trigger="keyup focusout"
                            onkeypress="numericOnly(event)"
                            onkeyup="thousandFormat(this)">
                          @if($errors->has('order'))                   
                            <span class="help-block">{{ $errors->first('order') }}</span>
                          @endif
                        </div>
                        <div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
                          <label for="fstatus">Status <span class="text-danger">*</span></label>
                          <select class="form-control" name="status" id="fstatus" required data-parsley-trigger="keyup focusout">
                            <option value="">-- Select Option --</option>
                            @foreach(config('frames.publish_status') as $status)
                              <option value="{{ $status['value'] }}" {{ (old('status')==$status['value']) ? 'selected' : '' }}>{{ $status['name'] }}</option>
                            @endforeach
                          </select>
                          @if($errors->has('status'))                    
                            <span class="help-block">{{ $errors->first('status') }}</span>
                          @endif
                        </div>              
          
                      </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('faq.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
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
    @include('frames::partials.script')
@endsection
