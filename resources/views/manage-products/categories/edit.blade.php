@extends('layouts.master')
@section('title', 'Categories')
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
<div class="main-content">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Categorie</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/categories') }}">CategorieTables</a></li>
                        <li class="breadcrumb-item">EditCategorie</li>
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
                    <h3 class="card-title">Edit categorie</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" id="quickForm" action="{{ route('categories.update', $categorie->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="cat1">Categorie name</label>
                                        <input type="text" name="categorie-name" value="{{ $categorie->name }}" class="form-control" id="cat1" placeholder="Enter categorie name ..">
                                        @if($errors->has('categorie-name'))
                                            <span class="error badge badge-danger">{{ $errors->first('categorie-name') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="cat2">Categorie image</label>
                                        <input type="file" name="categorie-image" value="{{ $categorie->image }}" class="form-control" id="cat2" placeholder="Enter categorie image ..">
                                        @if($errors->has('categorie-image'))
                                            <span class="error badge badge-danger">{{ $errors->first('categorie-image') }}</span>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="cat3">Categorie color</label>
                                        <input type="color" name="categorie-color" value="{{ $categorie->color }}" class="form-control" id="cat3" placeholder="Enter role name ..">
                                        @if($errors->has('categorie-color'))
                                            <span class="error badge badge-danger">{{ $errors->first('categorie-color') }}</span>
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
