@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> ADD STOCKIST USER</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/admin_stockist_user'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#stockist-user-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>



    <div class="col-md-12 form-group-container">
        <form id="stockist-user-add-form" method="post" class="col-md-12">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="form-group col-md-12">
                <label for="stockist id" class="col-md-2 control-label">Select Stockist</label>
                <div class="col-md-10">
                  @if($errors->first('stockist_id'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_id')}}</li>
                      </ul>
                    </div>
                  @endif
                  <select name="stockist_id" class="form-control">
                    <option >Select Stockist</option>
                    @if($_stockist)
                      @foreach($_stockist as $option)
                        <option value="{{$option->stockist_id}}" {{$option->stockist_id == Request::old('stockist_id') ? 'selected' : ''}}>{{$option->stockist_full_name}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
              <div class="form-group col-md-12">
                <label for="stockist_email" class="col-md-2 control-label">Email</label>
                <div class="col-md-10">
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
                <label for="Username" class="col-md-2 control-label">Username</label>
                <div class="col-md-10">
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
                <label for="Password" class="col-md-2 control-label">Password</label>
                <div class="col-md-10">
                  @if($errors->first('stockist_pw'))
                    <div class="alert alert-danger">
                      <ul>
                        <li>{{$errors->first('stockist_pw')}}</li>
                      </ul>
                    </div>
                  @endif
                  <input type="text" class="form-control" id="" placeholder="" name="stockist_pw" value="{{Request::old('stockist_pw')}}">
                </div>
              </div>
      
        </form>
    </div>
@endsection
@section('script')
@endsection
