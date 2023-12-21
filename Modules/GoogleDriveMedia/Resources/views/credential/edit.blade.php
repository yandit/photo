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
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    {!! Form::open(['route' => ['googledrivecredential.update', $customer->id], 'method' => 'PUT', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formGoogleDriveMedia']) !!}
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
                        <div style="margin-top: 25px">
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h4 class="box-title">API Credentials</h4>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:void(0)" class="btn btn-box-tool" id="add-row">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body table-responsive" style="padding: 0px">
                                    <table class="table table-bordered table-condensed" id="table-credential-details">
                                        <thead>
                                            <tr>
                                                <th>Disk</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($credential)
                                                @foreach($credential->credential_details as $detail)
                                                    <tr>
                                                        <td class="hidden id">
                                                            <input type="text" name="id[]" value="{{ $detail->id }}">
                                                        </td>
                                                        <td>
                                                        <select name="disk_id[]" class="select2" style="width: 100%" placeholder="Disk Name">
                                                            <option value=""></option>
                                                            @foreach($disks as $disk)
                                                                <option value="{{ $disk->id }}" {{$detail->disk_id == $disk->id ? 'selected': ''}}>{{ $disk->disk_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="is_active" value="{{ $detail->is_active }}" {{$detail->is_active ? 'checked': ''}}>
                                                            <input type="hidden" name="is_active[]" value="{{ $detail->is_active }}">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-warning btn-delete-row">
                                                                <div class="hidden">
                                                                    <input type="text" name="is_deleted[]" value="false">
                                                                </div>
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="hidden id">
                                                        <input type="text" name="id[]">
                                                    </td>
                                                    <td>
                                                        <select name="disk_id[]" class="select2" style="width: 100%" placeholder="Disk Name">
                                                            <option value=""></option>
                                                            @foreach($disks as $disk)
                                                                <option value="{{ $disk->id }}">{{ $disk->disk_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="is_active">
                                                        <input type="hidden" name="is_active[]" value="0">
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-warning btn-delete-row">
                                                            <div class="hidden">
                                                                <input type="text" name="is_deleted[]" value="false">
                                                            </div>
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    <script>
        $(document).ready(function(){
            handleAddRow()
            handleDeleteRow()
            handleIsActive()
        })

        const handleIsActive = function(){
            $(document).on('change', '.is_active', function () {
                $('.is_active').not(this).prop('checked', false);
                const input_is_active = $(this).siblings('[name="is_active[]"]')
                input_is_active.val(1)
                $('input[name="is_active[]"]').not(input_is_active).val(0);
            });
        }

        const handleAddRow = function(){
            $('#add-row').click(function(){
                let disks = {!! json_encode($disks->toArray()) !!};
                // disks.forEach(function(v){
                //     return `<option value="${v.id}">${v.disk_name}</option>`
                // })
                const templates = `
                    <tr>
                        <td class="hidden id">
                            <input type="text" name="id[]">
                        </td>
                        <td>
                            <select name="disk_id[]" class="select2">
                                <option value=""></option>
                                ${(disks.map(function(v){
                                    return `<option value="${v.id}">${v.disk_name}</option>`
                                }))}
                            </select>
                        </td>
                        <td>
                            <input type="checkbox" class="is_active">
                            <input type="hidden" name="is_active[]" value="0">
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-warning btn-delete-row">
                                <div class="hidden">
                                    <input type="text" name="is_deleted[]" value="false">
                                </div>
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `

                $('#table-credential-details').find('tbody').append(templates)
                $('.select2').select2({
                    placeholder: 'Please Select...',
                    width: '100%'
                });
            })
        }

        const handleDeleteRow = function(){
            $(document).on('click', '.btn-delete-row', function(){
                $(this).find('[name="is_deleted[]"]').val(true)
                $(this).closest('tr').hide()
            })
        }
    </script>
@endsection
