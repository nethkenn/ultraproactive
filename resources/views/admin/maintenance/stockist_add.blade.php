@extends('admin.layout')
@section('content')

	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> ADD STOCKIST </h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/admin_stockist'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#stockist-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>



    <div class="col-md-12 form-group-container">
        <form id="stockist-add-form" method="post" class="col-md-12">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="form-group col-md-12">
                <label for="Name" class="col-md-2 control-label">Stockist Name</label>
                <div class="col-md-10">
                  @if($errors->first('stockist_full_name'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_full_name')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_full_name" value="{{Request::old('stockist_full_name')}}">
                </div>
              </div>
              <div class="form-group col-md-12">
                <label for="stockist type" class="col-md-2 control-label">Stockist Type</label>
                <div class="col-md-10">
                                    @if($errors->first('stockist_type'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_type')}}</li>
                      </ul>
                    </div>
                  @endif
                  <select name="stockist_type" class="form-control">
                      <option>Select Stockist Type</option>
                      @if($stockist_type)
                        @foreach($stockist_type as $type)
                          <option value="{{$type->stockist_type_id}}" {{Request::old('stockist_type') == $type->stockist_type_id ? 'selected' : '' }}>{{$type->stockist_type_name}}</option>
                        @endforeach
                      @endif
                  </select>
                </div>
              </div>

              <div class="form-group col-md-12">
                <label for="Stockist Location" class="col-md-2 control-label">Stockist Location</label>
                <div class="col-md-10">
                  @if($errors->first('stockist_location'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_location')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_location" value="{{Request::old('stockist_location')}}">
                </div>
              </div>

              <div class="form-group col-md-12">
                <label for="Stockist Address" class="col-md-2 control-label">Stockist Address</label>
                <div class="col-md-10">
                  @if($errors->first('stockist_address'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_address')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_address" value="{{Request::old('stockist_address')}}">
                </div>
              </div>

              <div class="form-group col-md-12">
                <label for="Stockist Contact Number" class="col-md-2 control-label">Stockist Contact Number</label>
                <div class="col-md-10">
                    @if($errors->first('stockist_contact_no'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_contact_no')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_contact_no" value="{{Request::old('stockist_contact_no')}}">
                </div>
              </div>

              <div class="form-group col-md-12">
                <label for="Stockist Email" class="col-md-2 control-label">Email </label>
                <div class="col-sm-10">
                  @if($errors->first('stockist_email'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_email')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_email" value="{{Request::old('stockist_email')}}">
                </div>
              </div>

                            <div class="form-group col-md-12">
                <label for="Stockist Username" class="col-md-2 control-label"> Stockist Username</label>
                <div class="col-sm-10">
                  @if($errors->first('stockist_un'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_un')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_un" value="{{Request::old('stockist_un')}}">
                </div>
              </div>

              <div class="form-group col-md-12">
                <label for="Stockist Password" class="col-md-2 control-label">Stockist Password </label>
                <div class="col-sm-10">
                  @if($errors->first('stockist_pw'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_pw')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="password" class="form-control" id="" placeholder="" name="stockist_pw">
                </div>
              </div>
        </form>
    </div>
@endsection
@section('script')
@endsection
