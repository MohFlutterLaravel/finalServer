@extends('layouts.master')
@section('title', 'Edit Permission')
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

<div class="main-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Permission</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/permissions') }}">PermissionTables</a></li>
                        <li class="breadcrumb-item">EditPermission</li>
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
                    @endif

                    <h3 class="card-title">Edit a permission</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" id="quickForm" action="{{ route('permissions.update', $permission->id ) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Permission name</label>
                                        <input type="text" name="permission-name" value="{{ $permission->name }}" class="form-control" id="exampleInputEmail1" placeholder="Enter permission name ..">
                                        @if($errors->has('permission-name'))
                                            <span class="error badge badge-danger">{{ $errors->first('permission-name') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Type your password ..">
                                        @if($errors->has('password'))
                                            <span class="error badge badge-danger">{{ $errors->first('password') }}</span>
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
