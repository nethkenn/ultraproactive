@extends('stockist.layout')
@section('content')
    <div class="row">
        <div class="header">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="title col-md-8">
                <h2><i class="fa fa-tag"></i>PRODUCT</h2>
            </div>
            <div class="buttons col-md-4 text-right">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table id="product-table" class="table table-bordered">
            <thead>
                <tr>
                    <th class="option-col">ID</th>
                    <th>Name</th>
                    <th>Stocks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($_product as $product)
                    <tr>
                        <td>{{$product->product_id}}</td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->stockist_quantity}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="header">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="title col-md-8">
                <h2><i class="fa fa-tag"></i>PACKAGE</h2>
            </div>
            <div class="buttons col-md-4 text-right">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table id="product-table" class="table table-bordered">
            <thead>
                <tr>
                    <th class="option-col">ID</th>
                    <th>Name</th>
                    <th>Stocks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($_package as $package)
                    <tr>
                        <td>{{$package->product_package_id}}</td>
                        <td>{{$package->product_package_name}}</td>
                        <td>{{$package->package_quantity}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
