@extends('layouts.master')
@section('title', 'Marques')
@section('marques-count')
<span class="badge badge-info right">
    {{ count($marques) }}
</span>
@endsection
@section('marque-active')
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
                    <h1>MarqueTables </h1>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('marques.create') }}" class=" btn btn-primary"> New Marque </a>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" v-model="selected" style="width: 100%;">
                                <option>All Familles</option>
                                @foreach ($categories as $categorie)
                                <option disabled style="background-color: black; color: white">{{ $categorie->name }}</option>
                                @foreach ($categorie->familles as $famille)
                                <option> {{ $famille->name }}</option>
                                @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item active">MarqueTables</li>
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
                        <h3 class="card-title">MarqueTable with all Marques <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Marque id</th>
                                    <th>Marque name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $categorie)
                                @foreach ($categorie->familles as $famille)
                                @foreach ($famille->marques as $marque)
                                <tr style="background-color: {{ $marque->famille->color }}">
                                    <td>{{ $marque->id }}</td>
                                    <td>{{ $marque->name }}</td>
                                    <td>{{ $marque->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('marques.destroy',$marque->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('marques.edit', $marque->id ) }}" class="btn btn-primary">Edit</a>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Marque id</th>
                                    <th>Marque name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                @foreach ($categories as $categorie)
                @foreach ($categorie->familles as $famille)
                <div class="card" v-if="selected === '{{ $famille->name }}'">
                    <div class="card-header">
                        <h3 class="card-title">MarqueTable with Marques of <strong class="text-success">{{ $famille->name }} Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Marque id</th>
                                    <th>Marque name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($famille->marques as $marque)
                                <tr style="background-color: {{ $marque->famille->color }}">
                                    <td>{{ $marque->id }}</td>
                                    <td>{{ $marque->name }}</td>
                                    <td>{{ $marque->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('marques.destroy',$marque->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('marques.edit', $marque->id ) }}" class="btn btn-primary">Edit</a>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Marque id</th>
                                    <th>Marque name</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

                @endforeach
                @endforeach

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var vue = new Vue({
        el: '#show',
        data: {
            selected: 'All Familles'
        }

    });
</script>
@endsection
