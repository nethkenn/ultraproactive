@extends('admin.layout')
@section('content')

	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Add New membership</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/membership'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#membership-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="membership-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                    <label for="membership_name">membership Name</label>
                    @if($_error['membership_name'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_name'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            		<input name="membership_name" value="" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>
            	<div class="form-group col-md-12">
                    <label for="membership_price">Membership Price</label>
                    @if($_error['membership_price'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_price'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            		<input name="membership_price" value="" required="required" class="form-control" id="" placeholder="" type="number">
            	</div>    	
        </form>
    </div>
@endsection