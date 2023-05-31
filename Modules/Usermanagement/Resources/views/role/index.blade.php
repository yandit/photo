@extends('usermanagement::admin.layouts.default')



@section('content')
		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Roles
        <small>data</small>
      </h1>
      {{-- <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>User</li>
        <li class="active">Roles</li>
      </ol> --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">              
              <div class="text-center" style="margin-bottom: 30px">
                <a class="btn btn-sm btn-primary" href="{{ route('role.create') }}" role="button"><i class="fa fa-plus"></i> Add New</a>
                <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modal-filter" role="button"><i class="fa fa-filter"></i> Filter</a>
                <a class="btn btn-sm btn-default hidden clear-filter" role="button"><i class="fa fa-eraser"></i> Clear</a>
              </div>

              <div class="table-responsive">
                <table id="tableWithSearch" class="table table-bordered table-hover dt-responsive nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Slug</th>
                      <th>Name</th>
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
                      <th>Slug</th>
                      <th>Name</th>										
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

      <div class="modal fade" id="modal-filter" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Filter Data</h3>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">Name</label>
                <input type="text" placeholder="name" id="name" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Start Date</label>
                <input type='text' id='startDate' placeholder='start date' class="form-control datepicker" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="">End Date</label>
                <input type='text' id='endDate' placeholder='end date' class="form-control datepicker" autocomplete="off">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id=btn-filter class="btn btn-primary">Filter</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
@endsection

@section('script')
	@parent
    <script>
      $(document).ready(function(){
		  	var list = "{{ route('role.list') }}";
        var settings = {
          responsive: true,
          columnDefs: [
            {responsivePriority: 1, targets: -1}
          ],
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
            { data:null, width: '80px', render:function(data, type, row, meta){
              var json = meta.settings.json;
              return (json.old_start + meta.row + 1);
            }},	                
            { data:'slug', orderable:false },
            { data:'name', orderable:false },
            { data:'created_at'},
            { data:'updated_at'},
            { data:null, orderable: false, render:function(data, type, row, meta){
              var edit = "{{ route('role.edit', ['role'=> '#id']) }}".replace('#id', data.id);
              var del = "{{ route('role.delete', ['role'=> '#id']) }}".replace('#id', data.id);

              var editButton = `<a class="btn btn-xs btn-primary btn-space" href="${edit}" role="button"><i class="fa fa-pencil"></i> Edit</a>`;              
              var deleteButton = `<a class="btn btn-xs btn-primary deleteDialog" href="${del}" data-title="${data.name}" role="button"><i class="fa fa-trash"></i> Delete</a>`;
              return editButton + deleteButton;
            }}
          ],
          ajax : {
            dataSrc : 'data',
            data: function(data){
              data.name = $('#name').val()
              data.startDate = $('#startDate').val();
              data.endDate = $('#endDate').val();
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
        $('#btn-filter').click(function(){
          dataTable.draw();
          $('#modal-filter').modal('hide')
          $('.clear-filter').removeClass('hidden')
        })

        $('.clear-filter').click(function(){
          $('#startDate').val('');
          $('#endDate').val('');
          $('#name').val('');
          dataTable.draw();
          $(this).addClass('hidden')
        })

        handleDeleteDialog(dataTable)

	    });
    </script>
@endsection