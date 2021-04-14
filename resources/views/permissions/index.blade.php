@extends('layouts.master')
@section('title', 'Permissions')
@section('permissions-count')
<span class="badge badge-info right">
    {{ count($permissions) }}
</span>
@endsection
@section('permission-active')
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
                    <h1>PermissionTables</h1>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('permissions.create') }}" class=" btn btn-primary"> New permission </a>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" v-model="selected" style="width: 100%;">
                                <option>All</option>
                                @foreach ($catpermissions as $catpermission)
                                <option> {{ $catpermission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item active">PermissionTables</li>
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
                <div class="card" v-if="selected === 'All'">
                    <div class="card-header">
                        <h3 class="card-title">PermissionTable with All permissions <strong class="text-success">Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Permission id</th>
                                    <th>Permission name</th>
                                    <th>Guard_name</th>
                                    <th>Permission categorie</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>{{ $permission->catpermission->name }}</td>
                                    <td>{{ $permission->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('permissions.destroy',$permission->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('permissions.edit', $permission->id ) }}" class="btn btn-primary">Edit</a>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Permission id</th>
                                    <th>Permission name</th>
                                    <th>Guard_name</th>
                                    <th>Permission categorie</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- /.card-body -->
                </div>

                @foreach ($catpermissions as $catpermission)
                <div class="card" v-if="selected === '{{ $catpermission->name }}'">
                    <div class="card-header">
                        <h3 class="card-title"> PermissionTable with permissions of <strong class="text-success">{{ $catpermission->name }} Active</strong> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Permission id</th>
                                    <th>Permission name</th>
                                    <th>Guard_name</th>
                                    <th>Roles assigned</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($catpermission->permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>
                                        @foreach ($permission->getRoleNames() as $role)
                                        <span class="badge badge-primary">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $permission->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('permissions.destroy',$permission->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('permissions.edit', $permission->id ) }}" class="btn btn-primary">Edit</a>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Permission id</th>
                                    <th>Permission name</th>
                                    <th>Guard_name</th>
                                    <th>Roles assigned</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- /.card-body -->
                </div>
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
            selected: 'All'
        }

    });
</script>
@endsection
