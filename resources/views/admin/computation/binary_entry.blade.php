@extends('admin.layout')
@section('content')
<div class="row header">
    <div class="title col-md-8">
                <h2><i class="fa fa-bullseye"></i> PAIRING COMBINATIONS</h2>
            </div>
            <div class="buttons col-md-4 text-right">
                <button onclick="location.href='admin/utilities/binary'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
                <button onclick="location.href='admin/utilities/binary/add?membership={{Request::input('id')}}'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD PAIRING COMBINATIONS</button>
            </div>      </div>
    </div>
    <div class="col-md-12">
        <table id="product-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>POINT (L)</th>
                    <th>POINT (R)</th>
                    <th>INCOME</th>
                    <th class="option-col"></th>
                    <th class="option-col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($_pairing as $pairing)
                <tr>
                    <td>{{ number_format($pairing->pairing_point_l, 2) }}</td>
                    <td>{{ number_format($pairing->pairing_point_r, 2) }}</td>
                    <td>{{ number_format($pairing->pairing_income, 2) }}</td>
                    <td><a href="admin/utilities/binary/edit?id={{ $pairing->pairing_id }}&membership={{Request::input('id')}}">EDIT</a></td>
                    <td><a href="admin/utilities/binary/delete?id={{ $pairing->pairing_id }}&membership={{Request::input('id')}}">DELETE</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection