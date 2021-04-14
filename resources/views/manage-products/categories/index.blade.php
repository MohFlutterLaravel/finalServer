@extends('layouts.master')
@section('title', 'Categories')
@section('categories-count')
<span class="badge badge-info right">
    {{ count($categories) }}
</span>
@endsection
@section('categorie-active')
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
                    <h1>CategorieTables </h1>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('categories.create') }}" class=" btn btn-primary"> New Categorie </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active">CategorieTables</li>
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
                        <h3 class="card-title">CategorieTable with All Categorie <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Categorie id</th>
                                    <th>Categorie name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $categorie)
                                <tr>
                                    <td style="background-color: {{ $categorie->color }}">{{ $categorie->id }}</td>
                                    <td>{{ $categorie->name }}</td>
                                    <td>{{ $categorie->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('categories.destroy',$categorie->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button v-on:click="showFamille( {{ $categorie->id }}, '{{ asset('/storage/images/'.$categorie->image) }}')" data-toggle="modal" data-target="#modal-default" type="button" class="btn btn-info">Show</button>
                                            <a href="{{ route('categories.edit', $categorie->id ) }}" class="btn btn-primary">Edit</a>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Categorie id</th>
                                    <th>Categorie name</th>
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
                    <h4 class="modal-title">Categorie Infos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="img-model">
                    <img :src=" image " alt="avatar" style="width:100%; height: 15vw; object-fit: cover">
                  </div>
                    <h5>Categorie_name : <strong> @{{ name }} </strong> </h5>
                    <h5>Date : <strong> @{{ date }} </strong> </h5>
                    <h5>Familles :</h5>
                    <ul v-for="famille in familles">
                        <ol> <strong> @{{ famille.name }} </strong> </li>
                    </ul>
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
            familles: [],
            image: ''
        },
        methods: {
            showFamille(id, img) {
                vue.image = img;
                axios.get('http://localhost:8000/categories/' + id)
                    .then(function(response) {
                      console.log(response.data);
                        vue.name = response.data.name;
                        vue.date = response.data.date;
                        vue.familles = response.data.familles;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
        },
    });
</script>
@endsection
