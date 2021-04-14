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
@section('css')
<style>
    .container {
        padding: 2rem 0rem;
    }

    h4 {
        margin: 2rem 0rem 1rem;
    }

    .table-image {

        td,
        th {
            vertical-align: middle;
        }
    }
</style>
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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <h1>ImageTable </h1>
                </div>
                <div class="col-sm-4">
                    <button @click="showForm = !showForm" type="button" class=" btn btn-primary" name="button"> New image </button>
                </div>
                <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item active">ProduitimageTables</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section v-if="showForm" class="content">
      <div class="card">
        <div class="card-header">
          <h5>selectionner image</h5>
          <form class="" action="{{ route('produits.img.new') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="produitID" value="{{ $produit->id }}" hidden>
            <input type="file" name="add_img" >
            <input type="submit"value="submit">
          </form>
        </div>
        <div class="card-body">

        </div>
      </div>
    </section>
      <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-image">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produit->images as $image)
                        <tr>
                            <th scope="row">{{ $image->id }}</th>
                            <td class="w-25">
                                <a href="{{ asset('/storage/images/produits/'.$image->name) }}">
                                    <img src="{{ asset('/storage/images/produits/'.$image->name) }}" class="img-fluid img-thumbnail" alt="Sheep">
                                </a>
                            </td>
                            <td>
                                <form style="padding-top: 65px" action="{{ route('produits.img.update', $image->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <input name="product_id" value="{{ $produit->id }}" hidden>
                                    <input name="image" type="file">
                                    <input name="rank" min="1" max="{{ count($produit->images) }}" value="{{ $image->rank }}" type="number">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                    <button  @click="onDelete({{ $image->id }})" type="button" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var vue = new Vue({
        el: '#show',
        data: {
            showForm: false
        },
        methods: {
            onDelete(id) {

                axios.delete('http://localhost:8000/produits/img/delete', {params: {'id': id}})
                    .then(function(response) {
                      if (response.data.success) {
                        location.reload();
                      }
                    })

                    .catch(function(error) {
                        console.log(error);
                    });
            },
        },
    });
</script>
@endsection
