@extends('layouts.master')
@section('title', 'Familles')
@section('familles-count')
<span class="badge badge-info right">
    {{ count($familles) }}
</span>
@endsection
@section('famille-active')
active
@endsection
@section('product-manager-open')
menu-open
@endsection
@section('product-manager-active')
active
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
                    <h1>FamilleTables </h1>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('familles.create') }}" class=" btn btn-primary"> New Famille </a>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active">FamilleTables</li>
                    </ol>
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
                        <h3 class="card-title">FamilleTable with All Familles <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Famille id</th>
                                    <th>Famille name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($familles as $famille)
                                <tr style="background-color: {{ $famille->categorie->color }}">
                                    <td>{{ $famille->id }}</td>
                                    <td>{{ $famille->name }}</td>
                                    <td>{{ $famille->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('familles.destroy',$famille->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                              <button v-on:click="showMarque( {{ $famille->id }} )" data-toggle="modal" data-target="#modal-default" type="button" class="btn btn-info">Show</button>
                                            <a href="{{ route('familles.edit', $famille->id ) }}" class="btn btn-primary">Edit</a>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Famille id</th>
                                    <th>Famille name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
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
                    <h4 class="modal-title">Familles Infos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Famille_name : <strong> @{{ name }} </strong> </h5>
                    <h5>Date : <strong> @{{ date }} </strong> </h5>
                    <h5>Marques :</h5>
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>en</th>
                          <th>ar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="marque in marques">
                          <td>@{{ marque.name.en }}</td>
                          <td>@{{ marque.name.ar }}</td>
                        </tr>
                      </tbody>
                    </table>

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
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var vue = new Vue({
        el: '#show',
        data: {
            name: '',
            date: '',
            marques: []
        },
        methods: {
            showMarque(id) {
                axios.get('http://localhost:8000/familles/' + id)
                    .then(function(response) {
                        vue.name = response.data.name;
                        vue.date = response.data.date;
                        vue.marques = response.data.marques;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
        },
    });
</script>
@endsection
