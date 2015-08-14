@extends('member.layout')
@section('content')
		<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8 text-left">
				<h2><i class="glyphicon glyphicon-user"></i>E-PAYMENT TRANSACTIONS </h2>
				<h3>
					<i class="glyphicon glyphicon-shopping-cart"></i>  E-WALLET : {{$e_wallet}}
				</h3>
			</div>
			<div class="buttons col-md-4 text-right">
				<button type="button" class="btn btn-primary reload-wallet-show"><i class=" fa fa-plus"></i> Reload E-wallet</button>
				<button onclick="location.href='member/e-payment/'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> New Transaction</button>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		@if(Session::get('message'))
			<div class=" col-md-12 alert alert-success text-left">
				<ul class="col-md-12">
					<li>{{Session::get('message')}}</li>
				</ul>
			</div>
		@endif

		<table id="datatable" class="table table-bordered table-hovered table-striped">
			<thead>
				<tr>
					<th class="option-col">AGENT REF #</th>
					<th>TRANSACTION</th>
					<th>DATE</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

<div class="remodal" data-remodal-id="showDetails" data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div id="show-details-div">

  </div>
  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>

<div class="remodal" data-remodal-id="reload-e-wallet-modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
  <button data-remodal-action="close" class="remodal-close"></button>
  <form class="form-horizontal" method="post" id="reload-form">
  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  <div class="form-group">
  	<table class="table table-bordered table-striped table-hover">
  		<tr>
  			<td>Slot wallet</td>
  			<td>10000</td>
  		</tr>
  		  <tr>
  			<td>Amount</td>
  			<td>10.00 ( 100 AEU )/td>
  		</tr>
  		<tr>
  			<td>E-Wallet</td>
  			<td>1000 AEU (+ 100 AEU)</td>
  		</tr>
  	</table>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">Enter Points</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="slot-wallet-amount" placeholder="">
    </div>
  </div>
</form>
	<button data-remodal-action="cancel" class="remodal-cancel">OK</button>
    <button data-remodal-action="confirm" class="remodal-confirm" id="submit-reload-form">OK</button>
</div>
@endsection
@section('css')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection
@section('script')
	
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script type="text/javascript" scr="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script type="text/javascript">

		$(document).ready(function()
		{
			var $Table = $('#datatable').DataTable(
			{
		        processing: true,
		        serverSide: true,
		        ajax:{
		        	url:'member/e-payment/transaction-log/get_data',
		        	// data:{
		        	//    	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
		        	//    }
		    	},

		        columns: [
		            {data: 'agentRefNo', name: 'agentRefNo'},
		            {data: 'description', name: 'description'},
		            {data: 'created_at', name: 'created_at'},
		            {data: 'view_details', name: 'agentRefNo'},
		           	
		        ],
		        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
		        "oLanguage": 
		        	{
		        		"sSearch": "",
		        		"sProcessing": ""
		         	},
		        stateSave: true,
	    	});
		});
	</script>
	<script type="text/javascript" src="resources/assets/members/js/epayment_transaction.js"></script>
@endsection