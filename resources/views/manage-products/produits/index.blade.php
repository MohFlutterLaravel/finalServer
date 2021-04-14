@extends('layouts.master')
@section('title', 'Produits')
@section('products-count')
  <span class="badge badge-info right">
      @if ($produits > 99)
        99+
        @else
          {{$produits}}
      @endif
  </span>
@endsection
@section('product-active')
active
@endsection
@section('product-manager-open')
menu-open
@endsection
@section('product-manager-active')
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
                    <h1>ProduitTables </h1>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('produits.create') }}" class=" btn btn-primary"> New Produit </a>
                </div>
                <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item active">ProduitTables</li>
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
                <div class="card" v-if="selected === 'All Familles'">
                    <div class="card-header">
                        <h3 class="card-title">ProduitTable with all Produits <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="produits-table" class="table table-striped table-bordered dt-responsive nowrap table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product id</th>
                                    <th>Product name</th>
                                    <th>Marque</th>
                                    <th>Prix achat</th>
                                    <th>Prix vente</th>
                                    <th>Remise %</th>
                                    <th>Description</th>
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
                    <h4 class="modal-title">Product info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="img-model">
                    <img class="d-block w-100">
                  </div>
                    <h5>actions</h5>
                    <form id="deleteProduct" action="" method="post">
                        @csrf
                        @method('delete')
                        <a id="editProduct"href="" class="btn btn-primary">Edit produit</a>
                        <a id="editImage"href="#" class="btn btn-success">Edit image</a>
                        <button type="submit" class="btn btn-danger">Delete produit</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-left">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
$('#produits-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('datatables.produits') !!}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'marque', name: 'marque' },
        { data: 'pa', name: 'pa' },
        { data: 'pv', name: 'pv' },
        { data: 'remise', name: 'remise' },
        { data: 'description', name: 'description' }
    ]
});
$('#produits-table tbody').on('click', 'tr', function () {
  var data = jQuery(this).attr("id");
  $('#deleteProduct').attr("action", 'http://localhost:8000/produits/'+data);
  $('#editProduct').attr("href", 'http://localhost:8000/produits/'+data+'/edit ');
  $('#editImage').attr("href", 'http://localhost:8000/produits/img/'+data+'/edit ');
  $.ajax({
    type: "GET",
    url:'http://localhost:8000/getproduit/'+data,
    success: function( response) {
      for (var i = 0; i < response.images.length; i++) {
        if (response.images[i].rank == 1) {
          console.log(response.images[i].name);
          console.log(response.images[i].rank);
          $('.img-model img').attr("src", 'http://localhost:8000/storage/images/produits/'+response.images[i].name+'');
        }
      }
      if (response.image != null) {
        $('#imgProduct').attr("src", 'http://localhost:8000/storage/images/produits/'+response.image+'');
      }else {
        $('#imgProduct').attr("src", '');
      }
    }
  });
  });


});
</script>
@endsection
