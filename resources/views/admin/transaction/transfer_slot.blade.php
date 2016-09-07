@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>Transfer Slot Request</h2>
			</div>
		</div>
	</div>

    @if(Session::has('success'))
        <div class="alert alert-success">
            <ul>
                    <li>{{ $success }}</li>
            </ul>
        </div>
    @endif
	<div class="col-md-12">
		<table id="product-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Transfer ID</th>
                    <th data-hide="phone">Slot To Transfer</th>
                    <th data-hide="phone,phonie">Slot Owner</th>
                    <th data-hide="phone">Transfer to</th>
                    <th data-hide="phone">Date Request</th>
                    <th data-hide="phone">Status</th>
                    <th data-hide="phone,phonie"></th>
                </tr>
            </thead>
            <tbody>
                @if($_request)
                    @foreach ($_request as $request)  
                        <tr class="tibolru">
                            <td>{{$request->transfer_id}}</td>
                            <td>{{$request->owner_slot_id}}</td>
                            <td>{{App\Tbl_account::where('account_id',$request->owner_account_id)->first()->account_name}}</td>
                            <td>{{App\Tbl_account::where('account_id',$request->transfer_to_account_id)->first()->account_name}}</td>
                            <td>{{$request->transfer_date}}</td>
                           
                            @if($request->archived == 1)
                            <td>Expired</td>
                        	@elseif($request->transfer_status == 1)
                        	<td>Transferred</td>
                        	@elseif($request->transfer_status == 2)
                        	<td>Cancelled</td>
                        	@else
                        	<td>Pending</td>
                        	@endif

                    		@if($request->archived == 1)
                            <td></td>
                        	@elseif($request->transfer_status == 1)
                        	<td></td>                        	
                        	@elseif($request->transfer_status == 2)
                        	<td></td>
                        	@else
                        	<td><a href="admin/transaction/sales/transfer_slot_request/transfer?id={{$request->transfer_id}}">Approve</a>|<a href="admin/transaction/sales/transfer_slot_request/transfer_decline?id={{$request->transfer_id}}">Cancel</a></td>
                        	@endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
		</table>
	</div>
@endsection
