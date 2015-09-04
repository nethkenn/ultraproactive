@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-tag"></i>STOCKIST USER</h2>
			</div>
		</div>
	</div>
 	@if(Session::has('success'))
			    <div class="alert alert-success">
			        <ul>
			            <li>{{ $_success }}</li>
			        </ul>
			    </div>
	@endif
	<div class="col-md-12">
		<table id="datatable" class="table table-bordered">
			<thead>
				<tr>
					<th>Stockist ID</th>
					<th>Stockist Name</th>
					<th>Stockist Wallet</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($_stockist as $stockist)
				<tr>
					<td>{{$stockist->stockist_id}}</td>
					<td>{{$stockist->stockist_full_name}}</td>
					<td>{{number_format($stockist->stockist_wallet,2)}}</td>
					<td><a href="javascript:" id="{{$stockist->stockist_id}}" class="give">Give Amount</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="remodal create-slot" data-remodal-id="process" data-remodal-options="hashTracking: false">
	<form method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="stockist" id="stockistid">
	<label for="amount">Amount</label>
	<input type="number" class="form-control" name="amount" id="amount" required autocomplete="off" id="amount" step="0.01">
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="proccess">Process</button>
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript">

$(document).ready(function()
{
	$(".give").click(function(){
		$("#stockistid").val($(this).attr('id'));
		$("#amount").val("");
		var inst = $('[data-remodal-id=process]').remodal();
    	inst.open(); 
	});

});

</script>
@endsection
