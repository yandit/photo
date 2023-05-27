@extends('faq::layouts.default')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit FAQ
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form FAQ</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    {!! Form::open(['route' => ['faq.update', $faq->id], 'method' => 'PUT', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formFaq']) !!}
                    <div class="box-body">

                        <div class="form-group {{ $errors->first('question') ? 'has-error' : '' }}">
                            <label for="fquestion">Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fquestion" placeholder="Question"
                                name="question" value="{{ old('question', $faq->question) }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('question'))
                                <span class="help-block">{{ $errors->first('question') }}</span>
                            @endif
                        </div>


                        <div class="form-group {{ $errors->first('answer') ? 'has-error' : '' }}">
                            <label for="fanswer">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" class="form-control" id="fanswer" rows="4" required
                                data-parsley-trigger="keyup focusout">{{ old('answer', $faq->answer) }}</textarea>
                            @if ($errors->has('answer'))
                                <span class="help-block">{{ $errors->first('answer') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('order') ? 'has-error' : '' }}">
                            <label for="forder">Order <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="forder" placeholder="Order"
                                name="order" value="{{ old('order', $faq->order) }}" required
                                data-parsley-trigger="keyup focusout">
                            @if ($errors->has('order'))
                                <span class="help-block">{{ $errors->first('order') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('status') ? 'has-error' : '' }}">
                            <label for="fstatus">Status</label>
                            <select class="form-control" name="status" id="fstatus" required
                                data-parsley-trigger="keyup focusout">
                                <option value="">-- Select Option --</option>
                                @foreach (config('faq.enable_disable') as $status)
                                    @php
                                        $selected = old('status', $faq->status) == $status['value'] ? 'selected' : '';
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
                            <a href="{{ route('faq.index') }}" class="btn btn-info"><i class="glyphicon glyphicon-backward"></i> Back</a>
                            <button type="submit" class="btn btn-danger"> <i class="glyphicon glyphicon-save"></i> Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

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
                                    <td>: {{$faq->created_by->name}}</td>
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
    @include('faq::partials.script')
@endsection
