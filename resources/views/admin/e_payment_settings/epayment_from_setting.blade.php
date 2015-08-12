@extends('admin.layout')
@section('content')

	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> E-Payment / E-Remit Settings </h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	    	<button onclick="$('#stockist-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>



    <div class="col-md-12 form-group-container">
        <form id="stockist-add-form" method="post" class="col-md-12">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @if($_service_charge)
                @foreach($_service_charge as $service_charge)
                  <div class="form-group col-md-12">
                    <label for="value" class="col-md-2 control-label">{{$service_charge->service_charge_name}}</label>
                    <div class="col-sm-10">
                      @if($errors->first(''))
                        <div class="alert alert-danger">
                          <ul>
                            <li>{{$errors->first('')}}</li>
                          </ul>
                        </div>
                      @endif
                      <input type="number" class="form-control" id="" placeholder="PHP" name="service_charge[{{$service_charge->service_charge_id}}]" value="{{$service_charge->value}}">
                    </div>
                  </div>
                @endforeach
              @endif
        </form>
    </div>
@endsection
@section('script')
@endsection
