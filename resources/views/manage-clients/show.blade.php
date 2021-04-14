@extends('layouts.master')
@section('title', 'Clients')
@section('client-active')
active
@endsection
@section('client-manager-open')
menu-open
@endsection
@section('client-manager-active')
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
                    <h1>Details</h1>
                </div>
                <div class="col-sm-4">
                    <!--a href="" class=" btn btn-primary"> New Produit </a-->
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/clients') }}">Clients</a></li>
                                <li class="breadcrumb-item active">{{ $client->first_name }}</li>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Completed purchases successfully</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">820</span>
                                <span>Visitors Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 12.5%
                                </span>
                                <span class="text-muted">Since last week</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">

                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> This Week
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Last Week
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"> <strong>Orders</strong> </h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download" data-toggle="tooltip" title="Print"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle dt-responsive nowrap table-hover ">

                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>statut</th>
                                    <th>Taxe</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->orders as $order)
                                <tr>
                                    <td>
                                        #{{ $order->id }}
                                    </td>
                                    <td>
                                        @if ( $order->status == 'new')
                                        <span class="badge badge-warning">{{ $order->status }}</span>
                                        @endif
                                        @if ( $order->status == 'shipped')
                                        <span class="badge badge-info">{{ $order->status }}</span>
                                        @endif
                                        @if ( $order->status == 'valide')
                                        <span class="badge badge-success">{{ $order->status }}</span>
                                        @endif
                                        @if ( $order->status == 'rejected')
                                        <span class="badge badge-danger">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $order->tarif_liv }}
                                        <small class="text-success mr-1">
                                            DZD
                                        </small>
                                    </td>
                                    <td>
                                        {{ $order->total }}
                                        <small class="text-success mr-1">
                                            DZD
                                        </small>
                                    </td>
                                    <td>
                                        {{ $order->created_at->format('d/m/Y')}}
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.details', $order->id) }}">
                                          <i class="fa fa-info-circle " aria-hidden="true" data-toggle="tooltip" title="more .." style="color: #4846cc; cursor: pointer;"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Sales</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">$18,230.00</span>
                                <span>Sales Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 33.1%
                                </span>
                                <span class="text-muted">Since last month</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> This year
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Last year
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Orders Overview</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-tool">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-tool">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-danger text-xl">
                                <i class="fas fa-heart-broken"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i class="ion ion-android-arrow-down text-danger"></i> {{ $rejected_orders }}

                                </span>
                                <span class="text-muted">ORDERS REJECTED</span>

                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-success text-xl">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i class="ion ion-android-arrow-up text-success"></i>
                                    {{ $valide_orders }}
                                </span>
                                <span class="text-muted">ORDERS VALIDE</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-primary text-xl">
                                <i class="fa fa-truck bounce" aria-hidden="true"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i class="ion ion-android-arrow-up text-success"></i>
                                    {{ $cours_orders }}
                                </span>
                                <span class="text-muted">ORDERS PROCESS</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <p class="text-warning text-xl">
                                <i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
                                <span class="sr-only">Loading...</span>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    {{ $attend_orders }}
                                </span>
                                <span class="text-muted">ORDERS VERIFICATION </span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
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
