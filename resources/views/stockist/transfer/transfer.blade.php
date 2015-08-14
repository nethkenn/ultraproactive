@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Transfer </h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	    		  <button onclick="location.href='stockist/transfer_wallet#view_history'" type="button" class="btn btn-default">View History</button>
	      		  <button onclick="$('#stockist-type-add-form').submit();" type="button" class="btn btn-primary">Transfer</button>
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
			    <div class="alert alert-success">
			        <ul>
			            <li>{{ $_success }}</li>
			        </ul>
			    </div>
		    @endif

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group col-md-6">
                <label for="username" class="col-sm-12 control-label" >Enter amount to transfer (Remaining Balance: {{number_format($wallet,2)}}) </label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="username" placeholder="" name="amount" value="{{Request::old('username')}}" required>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="member" class="col-sm-12 control-label" >Transfer to:</label>
                <div class="col-sm-12">
                	<select class="form-control" name="member">
                		@foreach($_slot as $slot)
                		<option value="{{$slot->slot_id}}">Slot #{{$slot->slot_id}} ({{$slot->account_name}})</option>
                		@endforeach
                	</select>
                </div>
            </div>

        </form>
    </div>



  <div class="remodal" data-remodal-id="view_history">
	  <button data-remodal-action="close" class="remodal-close"></button>
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr class="text-center">

						<th>Stockist User</th>
						<th>Stockist Log</th>

					</tr>
				</thead>
				<tbody>
					@foreach($stockist_log as $log)
						<tr>
							<td>{{$log->stockist_un}}</td>
							<td>{{$log->stockist_log}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
  </div>
@endsection
@section('script')
@endsection