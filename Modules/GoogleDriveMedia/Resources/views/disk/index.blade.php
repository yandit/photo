@extends('googledrivemedia::layouts.default')

@section('content')
		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Disk
        <small>page</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-header">

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="text-center" style="margin-bottom: 30px">
                <a class="btn btn-sm btn-warning" href="{{ route('googledrivedisk.create') }}" role="button"><i class="fa fa-plus"></i> Add New</a>
                <a class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#modal-filter" role="button"><i class="fa fa-filter"></i> Filter</a>
                <a class="btn btn-sm btn-default hidden clear-filter" role="button"><i class="fa fa-eraser"></i> Clear</a>
              </div>

              <div class="table-responsive">
                <table id="tableWithSearch" class="table table-bordered table-hover dt-responsive nowrap table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Disk Name</th>
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
                      <th>Disk Name</th>
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
                <label for="">Disk Name</label>
                <input type="text" placeholder="disk name" id="disk_name" class="form-control">
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
              <button type="button" id=btn-filter class="btn btn-warning">Filter</button>
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
          searching: false,
          columns: [
            { data:null, width: '80px', render:function(data, type, row, meta){
              var json = meta.settings.json;
              return (json.old_start + meta.row + 1);
            }},
            { data:'disk_name'},
            { data:'created_at'},
            { data:'updated_at'},
            { data:null, orderable: false, render:function(data, type, row, meta){	               		
              var editButton = '<a class="btn btn-xs btn-warning btn-space" href="'+ ADMIN_URL + '/google-drive/disk/edit/' + data.id +'" role="button"><i class="fa fa-pencil"></i> Edit</a>';
              var deleteButton = '<a class="btn btn-xs btn-warning deleteDialog" href="'+ ADMIN_URL + '/google-drive/disk/delete/' + data.id +'" data-title="'+data.disk_name+'" role="button"><i class="fa fa-trash"></i> Delete</a>';
              return editButton + deleteButton;
            }}
          ],
          ajax : {
              dataSrc : 'data',
              data: function(data){
                data.startDate = $('#startDate').val();
                data.endDate = $('#endDate').val();
                data.disk_name = $('#disk_name').val();
              },
              timeout: 15000,
              beforeSend: function(request){
                  Pace.restart();
              },
              complete:function(){
                  Pace.stop();
              },
              xhrFields : {
                  withDisks : true
              },
              crossDomain : true,
              url : ADMIN_URL + '/google-drive/disk/list',
              type : 'POST',
              error: function( xhr, textStatus, error)
              {
                  console.log(error);
                  alert('An Error Occurred');
              }
          },
          initComplete: function() {
            var api = this.api();                   
            var filterTextTimeout;              
            $(".dataTables_filter input")
              .unbind()
              .bind("input", function(e) {
                var item = $(this);
                clearTimeout(filterTextTimeout);
                filterTextTimeout = setInterval(function(){
                  searchTerm = $(item).val();
                  api.search(searchTerm).draw();
                  clearTimeout(filterTextTimeout);
                }, 700);
              });
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
          $('#disk_name').val('');
          $('#pageLen').val('10').trigger('change');
          dataTable.draw();
          $(this).addClass('hidden')
        })

        handleDeleteDialog(dataTable)
        
	    });
    </script>
@endsection