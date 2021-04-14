@extends('layouts.master')
@section('title', '403')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>403 Unauthorized</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">403 Unauthorized</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-danger">403</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>

                <p>
                    You do not have permission to access this page and any illegal attempt will receive an alert from the administrator
                    <a href="{{ route('home') }}">
                        <br>
                        Go Home now !</a>
                    <br>
                    or try using the search form.
                </p>

                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-danger"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
</div>
@endsection
