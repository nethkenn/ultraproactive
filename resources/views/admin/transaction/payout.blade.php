@extends('admin.layout')
@section('content')
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
                <tbody>
                  @foreach($data as $d)
                    <tr class="text-center">
                        <td>{{$d['account_name']}}</td>
                        <td>{{$d['count']}}</td>
                        <td>{{$d['type']}}</td>
                        <td>{{$d['sum']}}</td>
                        <td>{{$d['deduction']}}</td>
                        <td>{{$d['total']}}</td>
                        <td>{{$d['date']}}</td>
                        <td><a class="showmodal-b" json="{{$d['json']}}" style="cursor:pointer;">Breakdown</a></td>
                        <td><a class="showmodal-p" style="cursor:pointer;">Proccess</a></td>
                    </tr>
                  @endforeach 
                </tbody>
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
            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Request From</label>
                <div class="col-sm-9">
                    <input class="form-control" id="1" name="request" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="2" class="col-sm-3 control-label">Amount</label>
                <div class="col-sm-9">
                    <input class="form-control" id="2" name="amount" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="3" class="col-sm-3 control-label">Payment Type</label>
                <div class="col-sm-9">
                    <input class="form-control" id="3" name="payment" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="4" class="col-sm-3 control-label">Bank Name</label>
                <div class="col-sm-9">
                    <input class="form-control" id="4" name="bankname" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="5" class="col-sm-3 control-label">Bank Account Name</label>
                <div class="col-sm-9">
                    <input class="form-control" id="5" name="bankaccount" value="">
                </div>
            </div>

            <div class="form-group para">
                <label for="6" class="col-sm-3 control-label">Bank Account Number</label>
                <div class="col-sm-9">
                    <input class="form-control" id="6" name="banknumber" value="">
                </div>
            </div>         

    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
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



@section('script')
<script type="text/javascript" src="/resources/assets/admin/payout.js"></script>
@endsection