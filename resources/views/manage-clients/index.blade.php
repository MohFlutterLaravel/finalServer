@extends('layouts.master')
@section('title', 'Clients')
@section('clients-count')
  <span class="badge badge-info right">
      @if ($clients > 99)
        99+
        @else
          {{$clients}}
      @endif
  </span>
@endsection
@section('client-active')
active
@endsection
@section('client-manager-open')
menu-open
@endsection
@section('client-manager-active')
active
@endsection
<!-- add css code -->
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
@endsection
@section('content')
<div class="main-content" id="show">
    @if ($message = Session::get('success'))
    @section('script')
    <script>
        toastr.success('{{ $message }}')
    </script>
    @endsection
    @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <h1>ClientTables </h1>
                </div>
                <div class="col-sm-4">
                    <!--a href="" class=" btn btn-primary"> New Produit </a-->
                </div>
                <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item active">ClientTables</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ClientTable with all Clients <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="clients-table" class="table table-striped table-hover table-bordered dt-responsive nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Client id</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Phone number</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Join date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Client info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>actions</h5>
                    <form id="deleteClient" action="" method="post">
                        @csrf
                        @method('delete')
                        <a id="clientDetails" href="" class="btn btn-info">Details</a>
                        @role('admin')
                        <button type="button" class="btn btn-danger">Delete</button>
                        @endrole
                    </form>
                </div>
                <div class="modal-footer justify-content-left">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>
 $(document).ready(function() {
  var table =
$('#clients-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('datatables.clients') !!}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'first_name', name: 'first_name' },
        { data: 'last_name', name: 'last_name' },
        { data: 'gender', name: 'gender' },
        { data: 'birthday', name: 'birthday' },
        { data: 'phone_number', name: 'phone_number' },
        { data: 'address', name: 'address' },
        { data: 'email', name: 'email' },
        { data: 'created_at', name: 'created_at' }
    ]
});
setInterval( function () {
    table.ajax.reload( null, false ); // user paging is not reset on reload
}, 30000 );
$('#deleteClient').on('click', 'button', function (){
  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})
});
$('#clients-table tbody').on('click', 'tr', function () {
  var data = jQuery(this).attr("id");

  $('#deleteClient').attr("action", 'http://localhost:8000/clients/'+data);
 $('#clientDetails').attr("href", 'http://localhost:8000/clients/'+data);
});


});
</script>
@endsection
