@extends('admin.layout')
@section('content')

	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Add New Country</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/country'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>

    @if($_error)
        <div class="col-md-12 alert alert-danger form-errors">
            <ul>
                @foreach($_error as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
            		<label for="country_name">Country Name</label>
            		<input name="country_name" value="" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>
            	<div class="form-group col-md-12">
            		<label for="currency">Currency</label>
            		<input name="currency" value="" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>
            	<div class="form-group col-md-12">
            		<label for="rate">Conversion Rate</label>
            		<input name="rate" value="" required="required" class="form-control" id="" placeholder="" type="number">
            	</div>        	
        </form>
    </div>
@endsection