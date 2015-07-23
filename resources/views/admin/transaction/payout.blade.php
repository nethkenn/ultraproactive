@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Process Payout</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/accounts/field'" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> MANAGE FIELDS</button>
				<button onclick="location.href='admin/maintenance/accounts/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD ACCOUNT</button>
			</div>
		</div>
		<div class="filters "></div>
	</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('processed') ? '' : 'active' }}" href="admin/transaction/payout/">Current Request</a>
				<a class="{{$active = Request::input('processed') ? 'active' : '' }}" href="admin/transaction/payout/?processed=1">Processed Request</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Request ID</th>
						<th>Request From</th>
						<th>No. of slots</th>
						<th>Payment</th>
						<th>Amount</th>
						<th>Deduction</th>
						<th>Total Amount</th>
						<th>Date</th>
						<th class="option-col" style="width:100px"></th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>


<!--<div class="remodal create-slot" data-remodal-id="process" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Process Payout
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
    <form class="form-horizontal" method="POST" id="createslot">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Request From</label>
                <div class="col-sm-9">
                    <input class="sponse form-control" id="1" name="sponsor" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Request From</label>
                <div class="col-sm-9">
                    <input class="sponse form-control" id="1" name="sponsor" value="">
                </div>
            </div>
    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="proccess">Process Payout</button>
    </form>
</div>-->




@endsection

@section('script')
<script type="text/javascript">
$(function() {
   $accountTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/transaction/payout/data',
	        	data:{
	        	   	processed : "{{$processed = Request::input('processed') ? 1 : 0 }}"
	        	   }
	    	},
        columns: [
            {data: 'request_id', name: 'request_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'slot_id', name: 'slot_id'},
            {data: 'type', name: 'type'},
            {data: 'amount', name: 'amount'},
            {data: 'deduction', name: 'deduction'},
            {data: 'total', name: 'total'},
            {data: 'encashment_date', name: 'encashment_date'},
            {data: 'Breakdown', name: 'Breakdown'},
            {data: 'Process', name: 'Process'},
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


@endsection