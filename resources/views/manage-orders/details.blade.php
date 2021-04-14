@extends('layouts.master')
@section('title', 'Orders')
@section('list-active')
active
@endsection
@section('order-manager-open')
menu-open
@endsection
@section('order-manager-active')
active
@endsection
<!-- add css code -->
@section('content')
<div class="main-content" id="show">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <h1>Order Details #{{ $order->id }}</h1>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/orders') }}">Orders_Table</a></li>
                                <li class="breadcrumb-item active">Orders_Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Tracking progress -->
        <ul class="progress-indicator">
            <li class="completed"> <span class="bubble"></span><i class="fa fa-cog fa-spin fa-1x fa-fw" style="cursor: pointer"></i> Processed {{ $order->created_at->format('M/d') }}</li>
            <li class="@if ($order->status == 'shipped' || $order->status == 'rejected' || $order->status == 'valide')
              completed
            @endif"> <span class="bubble"></span><i class="fa fa-rocket bounce" aria-hidden="true" style="cursor: pointer"></i> Shipped </li>
            <li class="@if ($order->status == 'rejected' || $order->status == 'valide')
              completed
            @endif"> <span class="bubble"></span><i class="fa fa-home" aria-hidden="true" style="cursor: pointer"></i> Arrived</li>
        </ul>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Products</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Remise</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits as $produit)
                                <tr>
                                    <td>
                                        @if ($produit->images->first())
                                        <img src="{{ asset('/storage/images/produits/'.$produit->images->first()->name) }}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                        @endif
                                        {{ $produit->name }}
                                    </td>
                                    <td> {{ $produit->pv }}Da </td>
                                    <td>
                                        <small class="text-success mr-1">
                                            {{ $produit->remise }}%
                                        </small>
                                    </td>
                                    <td> {{ $produit->pivot->qte }} </td>
                                    <td>
                                        @if ($produit->pivot->is_paid)
                                        <strong class="text-success">
                                            {{($produit->pv-(($produit->pv*$produit->remise)/100))*$produit->pivot->qte}}Da
                                        </strong>
                                        @else
                                        <strong class="text-danger">
                                            {{($produit->pv-(($produit->pv*$produit->remise)/100))*$produit->pivot->qte}}Da
                                        </strong>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- /.card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">Client info</h3>
                        <div class="card-tools">
                            <a href="{{ route('clients.show', $client->id) }}">
                                <i class="fa fa-info-circle " aria-hidden="true" data-toggle="tooltip" title="more .." style="color: #4846cc; cursor: pointer;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>
                                    @if ($client->gender == 'male')
                                    <i class="fas fa-mars text-primary" data-toggle="tooltip" title="male"></i>
                                    @else
                                    <i class="fas fa-venus text-warning" data-toggle="tooltip" title="female"></i>
                                    @endif
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </h5>
                            </div>
                            <div class="col-md-4">
                                {{ $client->address }}
                                <div class="text-muted">
                                  <i data-toggle="tooltip" title="latitude: {{ $order->location->lat }}   languitude: {{ $order->location->lang }}" class="fa fa-map-marker text-danger bounce" aria-hidden="true" style="cursor:pointer"></i>
                                  {{ $order->location->title }}</div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-info">{{ $client->phone_number }} <i class="fas fa-phone-volume"></i></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center" style="background-color: rgba(0, 0, 0, 0.08)">
                        <div class="row">
                            <div class="col-md-6">{{ $client->created_at->diffForHumans() }}</div>
                            <div class="col-md-6">
                                @if ($client->active)
                                  <strong class="text-primary" >Active</strong>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
<!-- /.content -->
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
