@extends('layouts.master')
@section('title', 'Roles')
@section('roles-count')
<span class="badge badge-info right">
    {{ count($roles) }}
</span>
@endsection
@section('role-active')
active
@endsection
@section('user-manager-open')
  menu-open
@endsection
@section('user-manager-active')
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
                    <h1>RoleTables </h1>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('roles.create') }}" class=" btn btn-primary"> New role </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active">RoleTables</li>
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
                        <h3 class="card-title">RoleTable with All roles <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Role id</th>
                                    <th>Role name</th>
                                    <th>Guard_name</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ $role->created_at->format('Y-m-d')}}</td>
                                    <td>{{ $role->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('roles.destroy',$role->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button v-on:click="showRole( {{ $role->id }} )" data-toggle="modal" data-target="#modal-default" type="button" class="btn btn-info">Show</button>
                                            <a href="{{ route('roles.edit', $role->id ) }}" class="btn btn-primary" >Edit</a>
                                           <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Role id</th>
                                    <th>Role name</th>
                                    <th>Guard_name</th>
                                    <th>Created_at</th>
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
                    <h4 class="modal-title">Role Infos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Role_name : <strong> @{{ name }} </strong> </h5>
                    <h5>Guard_name : <strong> @{{ guard }} </strong> </h5>
                    <h5>Date : <strong> @{{ date }} </strong> </h5>
                    <h5>Permissions :</h5>
                    <ul v-for="permission in permissions">
                        <ol> <strong> @{{ permission }} </strong> </li>
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

<!----------------------------------------------------------- VueJS -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var vue = new Vue({
        el: '#show',
        data: {
            name: '',
            guard: '',
            date: '',
            permissions : []
        },
        methods: {
            showRole(id) {
                axios.get('http://localhost:8000/roles/' + id)
                    .then(function(response) {
                      vue.name = response.data.name;
                      vue.guard = response.data.guard;
                      vue.date = response.data.date;
                      vue.permissions = response.data.permissions;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
        },
    });
</script>
@endsection
