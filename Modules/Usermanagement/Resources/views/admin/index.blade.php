@extends('usermanagement::admin.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin
      <small>data</small>
    </h1>
    <ol class="breadcrumb">
      {{-- <li><a href=""><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>User</li>
      <li class="active">Admin</li> --}}
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('usermanagement::admin.partials.flash')
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"></h3>
            <div class="btn-group pull-right m-b-10">
            	<a class="btn btn-primary" href="{{ route('admin.create') }}" role="button"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <div class="clearfix"></div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <!-- custom datatable filter -->
            <div class="row datatable-custom-filter">
              <div class="col-sm-1">                  
                <select name="page_len" id="pageLen" class="form-control">
                  <option value="10" selected>10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                </select>
                entries
              </div>
              <div class="col-sm-2">
                <input type='text' id='startDate' placeholder='start date' class="form-control datepicker">
              </div>
              <div class="col-sm-2">
                <input type='text' id='endDate' placeholder='end date' class="form-control datepicker">
              </div>
              <div class="col-sm-2">
                <input type='text' id='searchFilter' placeholder='search name' class="form-control" autocomplete="off">
              </div>                
            </div>
            
            <div class="table-responsive">
              <table id="tableWithSearch" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Created At</th>
                    <th>Modified At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>                
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Created At</th>
                    <th>Modified At</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

@endsection

@section('script')
	@parent
    <script>
    	$(document).ready(function(){

        var list = "{{ route('admin.list') }}";
        var settings = {
          destroy: true,
          scrollCollapse: true,
          autoWidth: false,
          deferRender: true,
          iDisplayLength: 10,
          processing: true,
          serverSide: true,
          order: [[ 0, "asc" ]],
          lengthChange: false,
          searching: false,
          columns: [
            { data:'no', width: '80px', render:function(data, type, row, meta){
              var json = meta.settings.json;
              return (json.old_start + meta.row + 1);
            }},	                
            { data:'email', orderable:false },
            { data:'name', orderable:false },
            { data:'status', orderable:false, render:function(data, type, row, meta){
              var label = (data=='active') ? 'success' : 'warning';
              return `<span class="label label-${label}">`+data.toUpperCase()+'</span>';
            } },
            { data:'last_login'},
            { data:'created_at'},
            { data:'updated_at'},
            { data:null, orderable: false, render:function(data, type, row, meta){	               		
              var edit = "{{ route('admin.edit', '#id') }}".replace('#id', data.id);
              var del = "{{ route('admin.delete', '#id') }}".replace('#id', data.id);

              var editButton = `<a class="btn btn-primary btn-space" href="${edit}" admin="button">Edit</a>`;
              var deleteButton = `<a class="btn btn-danger deleteDialog" href="${del}" data-title="${data.name}" role="button">Delete</a>`;
              return editButton + deleteButton;
            }}
          ],
          ajax : {
            dataSrc : 'data',
            data: function(data){
              data.startDate = $('#startDate').val();
              data.endDate = $('#endDate').val();
              data.search.value = $('#searchFilter').val();
            },
            timeout: 15000,
            beforeSend: function(request){
              Pace.restart();
            },
            complete:function(){
              Pace.stop();
            },
            xhrFields : {
              withCredentials : true
            },
            crossDomain : true,
            url : list,
            type : 'POST',
            error: function( xhr, textStatus, error)
            {
              console.log(error);
              alert('An Error Occurred');
            }
          },
          initComplete: function() {
          },
        };

        var dataTable = $('#tableWithSearch').DataTable(settings);        

        //  data filter
        var filterTextTimeout;
        $('#searchFilter').keyup(function(){
          clearTimeout(filterTextTimeout);          
          filterTextTimeout = setInterval(function(){                        
            dataTable.draw();
            clearTimeout(filterTextTimeout);
          }, 700);          
        });
        $('#pageLen').change(function(){
          dataTable.page.len( $(this).val() ).draw()
        });
        $('#startDate').change(function(){          
          if($('#endDate').val()){
            dataTable.draw();
          }          
        });
        $('#endDate').change(function(){          
          if($('#startDate').val()){
            dataTable.draw();
          }          
        });

      });
    </script>
@endsection