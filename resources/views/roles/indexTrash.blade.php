@extends('layouts.master')
@section('title', 'RolesTrash')
@section('roleTrash-active')
  active
@endsection
@section('trash-open')
  menu-open
@endsection
@section('trash-active')
  active
@endsection
@section('content')
<div class="main-content">
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
                <div class="col-sm-6">
                    <h1>RoleTrash</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active">RoleTrash</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @if (count($roles) > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">RoleTrash with All roles <strong class="text-danger">Inactive</strong> </h3>
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
                                        <form action="{{ route('roles.trash.restore',$role->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <button type="submit" class="btn btn-success">Restore</button>
                                        </form>
                                        <form action="{{ route('roles.trash.destroy',$role->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Destroy</button>
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
                @else
                <div class="center-ask">
                    <img src="{{ asset('dist/img/delete-trash.png') }}" class="rounded mx-auto d-block">
                </div>
                @endif
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->


</div>
@endsection
