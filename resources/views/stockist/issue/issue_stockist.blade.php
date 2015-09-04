@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> ISSUE STOCKS </h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="$('#stockist-type-add-form').submit();" type="button" class="btn btn-primary">Procceed</button>
	    </div>
    </div>

        <div class="col-md-12 form-group-container">
        <form id="stockist-type-add-form" method="post">
		    @if(Session::has('message'))
			    <div class="alert alert-danger">
			        <ul>
			            <li>{{ $_error }}</li>
			        </ul>
			    </div>
		    @endif
		    @if(Session::has('success'))
			    <div class="alert alert-danger">
			        <ul>
			            <li>{{ $_success }}</li>
			        </ul>
			    </div>
		    @endif
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group col-md-6">
                <label for="username" class="col-sm-12 control-label" >Enter Stockist Username</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="username" placeholder="" name="username" value="{{Request::old('username')}}">
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
@endsection