@extends('admin.layout')
@section('content')
  <div class="row">
        <div class="header">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="title col-md-8">
                <h2><i class="fa fa-cog"></i> COMPANY SETTINGS</h2>
            </div>
            <div class="buttons col-md-4 text-right">
                <button onclick="$('#company-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update Company Settings</button>
            </div>
        </div>
        <div class="form-group-container col-md-12">
        	<form id="company-form" action="admin/utilities/setting/submit" method="post">
        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	        	<div class="form-group col-md-6">
	        		<label for="c-name">Company Name</label>
	        		<input type="text" class="form-control" id="c-name" name="name" value="{{ $company->company_name }}">
	        	</div>
	        	<div class="form-group col-md-6">
	        		<label for="c-email">Company Email</label>
	        		<input type="text" class="form-control" id="c-email" name="email" value="{{ $company->company_email }}">
	        	</div>
	        	<div class="form-group col-md-6">
	        		<label for="c-phone">Contact Mobile Number</label>
	        		<input type="text" class="form-control" id="c-phone" name="mobile" value="{{ $company->company_mobile }}">
	        	</div>
	        	<div class="form-group col-md-6">
	        		<label for="c-telephone">Contact Telephone Number</label>
	        		<input type="text" class="form-control" id="c-telephone" name="telephone" value="{{ $company->company_telephone }}">
	        	</div>
	        	<div class="form-group col-md-12">
	        		<label for="c-address">Company Address</label>
	        		<textarea class="form-control" id="c-address" name="address">{{ $company->company_address }}</textarea>
	        	</div>
	        </form>
        </div>
    </div>
@endsection