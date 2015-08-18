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
			@if($errors->all())
				@foreach($errors->all() as $error)
					<div class=" col-md-12 alert alert-danger text-left">
						<ul class="col-md-12">
							<li>{{$error}}</li>
						</ul>
					</div>
				@endforeach
			@endif

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

<div class="remodal" data-remodal-id="reload-e-wallet-modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: true , closeOnConfirm : false">
  <button data-remodal-action="close" class="remodal-close"></button>
  <form class="form-horizontal" method="post" id="reload-form">
  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  <div class="form-group loader-container">
  	<img class="loader" src="/resources/assets/frontend/img/preloader_skype.GIF" style="display:none;">
  	<div id="point-conversion-table">
  		
  	</div>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-3 control-label">Enter Amount</label>
    <div class="col-sm-9">
      <input type="number" name="amount" class="form-control" id="slot-wallet-amount" placeholder="Slot wallet points">
    </div>
  </div>
</form>
	<button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm" id="submit-reload-form">OK</button>
</div>
@endsection
<style type="text/css">
	#point-conversion-table
	{
		min-height: 205px;
	}

	.loader-container{
		position: relative;
	}

	.loader{
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        z-index: 99;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
          -o-transform: translateY(-50%);
             transform: translateY(-50%);

	}

	.load_opacity{
		opacity: .5;
	}




</style>
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