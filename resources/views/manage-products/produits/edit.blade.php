@extends('layouts.master')
@section('title', 'NewProduit')
@section('product-active')
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

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Produit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/produits') }}">ProduitTables</a></li>
                        <li class="breadcrumb-item">EditProduit</li>
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
                    <h3 class="card-title">Edit a Produit</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('produits.update', $produit->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Famille</label>
                                    <select name="famille" @change="onChange($event)" class="form-control" style="width: 100%;">
                                    <option value="" disabled selected>Select your famille</option>
                                    @foreach ($categories as $categorie)
                                    <optgroup label="{{ $categorie->name }}">
                                        @foreach ($categorie->familles as $famille)
                                        <option value="{{ $famille->id }}">{{ $famille->name }}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Marque</label>
                                    <select name="marque-id" class="form-control select2" style="width: 100%;">
                                        <option :value="marque.id" v-for="marque in marques">
                                            @{{ marque.name.en }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ProductName">Product name</label>
                                    <input type="text" name="product-name" value="{{ $produit->name }}" class="form-control" id="ProductName" placeholder="Enter Product name ..">
                                    @if($errors->has('product-name'))
                                        <span class="error badge badge-danger">{{ $errors->first('product-name') }}</span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ProduitDescription">Product description</label>
                                    <textarea class="form-control" name="product-description" rows="3" id="ProduitDescription" placeholder="Enter Product description ..">{{ $produit->description }}</textarea>
                                    @if($errors->has('product-description'))
                                        <span class="error badge badge-danger">{{ $errors->first('product-description') }}</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ProductPA">Product PA</label>
                                    <input type="number" name="product-pa" value="{{ $produit->pa }}" class="form-control" id="ProductPA" placeholder="Enter Product PA ..">
                                    @if($errors->has('product-pa'))
                                        <span class="error badge badge-danger">{{ $errors->first('product-pa') }}</span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ProductPV">Product PV</label>
                                    <input type="number" name="product-pv" value="{{ $produit->pv }}" class="form-control" id="ProductPV" placeholder="Enter Product PV ..">
                                    @if($errors->has('product-pv'))
                                        <span class="error badge badge-danger">{{ $errors->first('product-pv') }}</span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ProductRE">Product RE</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-percent"></i></span>
                                    </div>
                                    <input type="number" name="product-re" value="{{$produit->remise }}" class="form-control" id="ProductRE" placeholder="Enter Product RE ..">
                                    @if($errors->has('product-re'))
                                        <span class="error badge badge-danger">{{ $errors->first('product-re') }}</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="form-check">
                            <input name="en-stock" type="checkbox" class="form-check-input" @if ($produit->active == 1) checked @endif >
                            <label class="form-check-label" for="exampleCheck1">En stock</label>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">Editer</button>
                        </div>
                    </form>
                    <!-- /.form -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var vue = new Vue({
        el: '#show',
        data: {
            marques: [],
        },
        methods: {
            onChange(event) {
                vue.marques = [];
                axios.get('http://localhost:8000/marques/getMarques/' + event.target.value)
                    .then(function(response) {
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
@section('script')
<script>
    $('.select2').select2();
</script>
@endsection
