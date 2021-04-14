@extends('layouts.master')
@section('title', 'Orders')
@section('lists-count')
  <span class="badge badge-info right">
      @if ($orders > 99)
        99+
        @else
          {{$orders}}
      @endif
  </span>
@endsection
@section('list-active')
active
@endsection
@section('order-manager-open')
menu-open
@endsection
@section('order-manager-active')
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
                    <h1>Rejected Orders</h1>
                </div>
                <div class="col-sm-4">
                  <div class="row route">
                    <div class="col-md-3">
                      <a href="{{ route('orders.rejected') }}">
                        <p class="text-danger text-xl">
                            <i class="fas fa-heart-broken"></i>
                        </p>
                      </a>
                    </div>
                      <div class="col-md-3">
                          <a href="{{ route('orders.valide') }}">
                            <p class="text-success text-xl">
                              <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </p>
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="{{ route('orders.shipped') }}">
                            <p class="text-primary text-xl">
                              <i class="fa fa-truck bounce" aria-hidden="true"></i>
                            </p>
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="{{ route('orders.new') }}">
                            <p class="text-warning text-xl">
                              <i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
                              <span class="sr-only">Loading...</span>
                            </p>
                          </a>
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders_Table</a></li>
                                <li class="breadcrumb-item active">Rejected_Orders</li>
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
                        <h3 class="card-title">Orders Table with all Orders <strong class="text-danger">Rejected</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="orders-table" class="table table-striped table-hover table-bordered dt-responsive nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Delivery Tax</th>
                                    <th>Total</th>
                                    <th>Requested On</th>
                                    <th>Requested By</th>
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
$('#orders-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('datatables.orders.rejected') !!}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'tarif_liv', name: 'tarif_liv' },
        { data: 'total', name: 'total' },
        { data: 'date', name: 'date' },
        { data: 'client', name: 'client' }
    ]
});
setInterval( function () {
    table.ajax.reload( null, false ); // user paging is not reset on reload
}, 30000 );
$('#orders-table tbody').on('click', 'tr', function () {
  var data = jQuery(this).attr("id");

  window.location.href = "http://localhost:8000/orders/details/"+data;
});



});
</script>
@endsection
