@extends('layouts.master')
@section('title', 'edit Role')
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
<div class="main-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/roles') }}">RoleTables</a></li>
                        <li class="breadcrumb-item">EditRole</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    @if (count($errors) > 0)
                    @section('script')
                    <script>
                        toastr.error('<strong>Whoops!</strong> There were some problems with your input.<br><br>')
                    </script>
                    @endsection
                    @else
                    <h3 class="card-title">Edit a role</h3>
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" id="quickForm" action="{{ route('roles.update', $role->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Role name</label>
                                        <input type="text" name="role-name" value="{{ $role->name }}" class="form-control" id="exampleInputEmail1" placeholder="Enter role name ..">
                                        @if($errors->has('role-name'))
                                            <span class="error badge badge-danger">{{ $errors->first('role-name') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Type your password ..">
                                        @if($errors->has('password'))
                                            <span class="error badge badge-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Reset Permissions</label>
                                        <select name="permissions[]" class="select2bs4" multiple="multiple" data-placeholder="Select a Permission" style="width: 100%;">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}"> {{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('permissions'))
                                            <span class="error badge badge-danger">{{ $errors->first('permissions') }}</span>
                                            @endif
                                    </div>
                                    OR
                                    <hr class="hr">
                                    <div class="form-group">
                                        <label>Add Permissions</label>
                                        <select name="add_permissions[]" class="select2bs4" multiple="multiple" data-placeholder="Select a Permission" style="width: 100%;">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}"> {{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('add_permissions'))
                                            <span class="error badge badge-danger">{{ $errors->first('add_permissions') }}</span>
                                            @endif
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Editer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
</div>
@endsection
