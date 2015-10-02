@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> STOCKIST LIST</h2>
			</div>
		</div>
		<div class="filters "></div>
	</div>
	@if($stockist)	
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>ID</th>
						<th>Stockist Name</th>
						<th class="col-md-2"></th>
						<th class="col-md-2"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($stockist as $stock)
					<tr>
						<td>{{$stock->stockist_id}}</td>
						<td>{{$stock->stockist_full_name}}</td>
						<td><a href="admin/stockist_inventory/refill?id={{$stock->stockist_id}}">Refill Product</a></td>
						<td><a href="admin/stockist_inventory/refill/package?id={{$stock->stockist_id}}">Refill Package</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
	</div>
	@endif
@endsection

