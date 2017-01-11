@extends('admin.layout')
@section('content')

        @if(Session::has('success'))
            <div class="alert alert-success">
                <ul>
                        <li>{{ $success }}</li>
                </ul>
            </div>
        @endif

	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Process Payout</h2>
			</div>
			<div class="buttons col-md-4 text-right">
                <button  type="button" id="autoencash" class="btn btn-primary"> Auto Encash All Wallet</button>
				<button  type="button" id="processall" class="btn btn-primary"> Process all Payout</button>
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
	<div class="processor col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th></th>
						<th>Request From</th>
                        <th>Username</th>
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


<div class="remodal create-slot" data-remodal-id="process" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Process Payout
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">

    <form class="form-horizontal" method="POST">

            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" class="secretid" name="idtoprocess">


            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Request From</label>
                <div class="col-sm-9">
                    <input class="form-control" id="1" name="request" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="5" class="col-sm-3 control-label">Type</label>
                <div class="col-sm-9">
                    <input class="form-control" id="5" name="type" value="">
                </div>
            </div>   
          

            <div class="form-group para">
                <label for="2" class="col-sm-3 control-label">Amount</label>
                <div class="col-sm-9">
                    <input class="form-control" id="2" name="amount" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="3" class="col-sm-3 control-label">Deduction</label>
                <div class="col-sm-9">
                    <input class="form-control" id="3" name="deduction" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="4" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-9">
                    <input class="form-control" id="4" name="total" value="">
                </div>
            </div>

  

    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="cancel_payout">Return Wallet</button>
    <button class="c_slot button"  type="submit" name="proccess">Process Payout</button>
    </form>
</div>

<div class="remodal create-slot" data-remodal-id="processall" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Process All Payout
    </div>
    <form class="form-horizontal" method="POST">

    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">

    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="processall">Process All</button>
    </form>
</div>

<div class="remodal create-slot" data-remodal-id="autoencash" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Encash All Wallet
    </div>
    <form class="form-horizontal" method="POST">

    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">

    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="encashall">Encash All Wallet</button>
    </form>
</div>

<div class="remodal create-slot" data-remodal-id="breakdown" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
       Breakdown
    </div>
    <div class="processor col-md-12">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Slot</th>
                        <th>Amount</th>
                        <th>Deduction</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody class="break text-center">
                </tbody>
            </table>
            Total:<span id="totalcontainer"> </span>
    </div>
  
</div>



@endsection
@section('css')
<style type="text/css">
    input[type=checkbox] 
    {
      transform: scale(2);
    }
</style>
@endsection


@section('script')
<script type="text/javascript">
if("{{Request::input('processed')}}" == 1)
{
      $(function() {
       $accountTable = $('#table').DataTable({
           
            order: [[ 8, "desc" ]],
            processing: true,
            serverSide: true,
             ajax:{
                    url:'admin/transaction/payout/data',
                    data:{
                        processed : "{{$processed = Request::input('processed') ? 1 : 0 }}"
                       }
                },
            columns: [
                {data: 'checked', name: 'checked'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account_username', name: 'account_username'},
                {data: 'count', name: 'count'},
                {data: 'type', name: 'type'},
                {data: 'sum', name: 'sum'},
                {data: 'deduction', name: 'deduction'},
                {data: 'total', name: 'total'},
                {data: 'encashment_date', name: 'encashment_date'},
                {data: 'json', name: 'processed_no'},

            ],
            "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
            "oLanguage": 
                {
                    "sSearch": "",
                    "sProcessing": ""
                },
            "initComplete": function(settings, json) 
            {
                // alert( 'DataTables has finished its initialisation.' );
            },
            stateSave: true,
        });
    });  
}
else
{
     $(function() {
       $accountTable = $('#table').DataTable({
            processing: true,
            serverSide: true,
             ajax:{
                    url:'admin/transaction/payout/data',
                    data:{
                        archived : "{{$processed = Request::input('processed') ? 1 : 0 }}"
                       }
                },
            columns: [
                {data: 'checked', name: 'checked'},
                {data: 'account_name', name: 'account_name'},
                {data: 'account_username', name: 'account_username'},
                {data: 'count', name: 'count'},
                {data: 'type', name: 'type'},
                {data: 'sum', name: 'sum'},
                {data: 'deduction', name: 'deduction'},
                {data: 'total', name: 'total'},
                {data: 'date', name: 'date'},
                {data: 'json', name: 'json'},
                {data: 'process', name: 'process'},
                
            ],
            "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
            "oLanguage": 
                {
                    "sSearch": "",
                    "sProcessing": ""
                },
            "drawCallback": function( settings ) 
            {

            },
            stateSave: true,
        });
    });   
}
// $(".processor").on("click","tr td:first-child",function()
// {
//     var checked_container  = $(this).find(".checked_container");
    
//     if(checked_container.is(':checked'))
//     {
//         checked_container.removeAttr("checked","checked"); 
//     }
//     else
//     {
//         checked_container.attr("checked","checked");
//     }
// });

$(".processor").on("click",".checked_container",function(e)
{
    	$.ajax({
			url: 'admin/transaction/payout/checked',
			type: 'GET',
			dataType: 'json',
			data: {id: $(this).attr("request_id")},
		})
// 		.done(function() 
// 		{
//           alert("Success");
//         });
});

</script>
<script type="text/javascript" src="/resources/assets/admin/payout.js"></script>
@endsection