@extends('admin.layout')
@section('content')
  <pre>
    {{var_dump($stockist_type->stockist_type_name)}}
  </pre>
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> EDIT STOCKIST TYPE</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/stockist_type'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#stockist-type-edit-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> UDPATE</button>
	    </div>
    </div>



    <div class="col-md-12 form-group-container">
        <form id="stockist-type-edit-form" method="post" action="admin/stockist_type/edit">
            @if($errors->all())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="stockist_type_id" value="{{$stockist_type->stockist_type_id}}">
            <div class="form-group col-md-6">
                <label for="stockist type name" class="col-sm-12 control-label" >Type Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_type_name" value="{{Request::old('stockist_type_name') ? : $stockist_type->stockist_type_name}}">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="stockist type discount" class="col-sm-12 control-label">Stockist Discount (%)</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="" placeholder="" name="stockist_type_discount" value="{{Request::old('stockist_type_discount') ? : $stockist_type->stockist_type_discount}}">
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="stockist type package discount" class="col-sm-12 control-label">Package Discount (%)</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="" placeholder="" name="stockist_type_package_discount"  value="{{Request::old('stockist_type_package_discount') ? : $stockist_type->stockist_type_package_discount}}">
                </div>
            </div>


            <div class="form-group col-md-6">
                <label for="stockist type minimum order" class="col-sm-12 control-label">Minimum Order</label>
                <div class="col-sm-12">

                  <input type="number" class="form-control" id="" placeholder="" name="stockist_type_minimum_order" value="{{Request::old('stockist_type_minimum_order') ? : $stockist_type->stockist_type_minimum_order}}">
                </div>
            </div>



        </form>
    </div>
@endsection
@section('script')
@endsection
<!-- <form >
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form> -->