@extends('admin.layout')
@section('content')

	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Check Claims</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href=''" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="membership-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                     <label for="voucher id">Voucher ID</label>
            		<input name="voucher_id" value="{{Request::input('voucher_id')}}" class="form-control" id="" placeholder="" type="text">
            	</div>
                <div class="form-group col-md-12">
                     <label for="voucher id">Voucher Code</label>
                    <input name="voucher_code" value="{{Request::input('voucher_code')}}"  class="form-control" id="" placeholder="" type="text">
                </div>
                <div class="form-group col-md-12">
                     <label for="account password">Enter Password</label>
                    <input name="account_password" value="{{Request::input('account_password')}}"  class="form-control" id="" placeholder="" type="password">
                </div>
                    <div class="form-group col-md-12">
                 <button type="submit" class="btn btn-default">Check Voucher Code</button> 
                </div>    	
        </form>

        

            @if($_message)
                <div class="col-md-12">
                    <ul class = "col-md-12">
                    @foreach ($_message as $message)
                        {{-- expr --}}
                  
                    
                   <li> {{$message}} </li>
                   
                    @endforeach
                    </ul>
                </div>
            @endif
        
    </div>
@endsection