@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Match / Update Product Points</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/binary'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-12">
                <label for="account_name">Product Name</label>
                <input value="{{ $data->product_name }}" disabled="disabled" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-12">
                <label for="account_contact">Income</label>
                <input name="binary_pts" value="{{ $data->binary_pts }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
        </form>
    </div>
@endsection