@extends('layouts.master')
@section('title', 'NewMarque')
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
<div class="main-content">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>New Marque</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/marques') }}">MarqueTables</a></li>
                        <li class="breadcrumb-item">NewMarque</li>
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
                    <h3 class="card-title">Create a new Marque</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" id="quickForm" action="{{ route('marques.store') }}" method="post">
                                @csrf
                                <div class="card-body">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Marque name fr</label>
                                      <input type="text" name="marque-name-en" value="{{ old('marque-name-fr') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter marque name ..">
                                      @if($errors->has('marque-name-en'))
                                          <span class="error badge badge-danger">{{ $errors->first('marque-name-en') }}</span>
                                          @endif
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Marque name ar</label>
                                      <input type="text" name="marque-name-ar" value="{{ old('marque-name-ar') }}" class="form-control" id="exampleInputEmail1" placeholder="ادخل اسم العلامة...">
                                      @if($errors->has('marque-name-ar'))
                                          <span class="error badge badge-danger">{{ $errors->first('marque-name-ar') }}</span>
                                          @endif
                                  </div>
                                    <div class="form-group">
                                        <select class="form-control" name="famille" style="width: 100%;">
                                            @foreach ($categories as $categorie)
                                            <option disabled style="background-color: black; color: white">{{ $categorie->name }}</option>
                                            @foreach ($categorie->familles as $famille)
                                            <option value="{{ $famille->id }}"> {{ $famille->name }}</option>
                                            @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Creer</button>
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
