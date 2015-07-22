@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-bullseye"></i> PAIRING COMBINATIONS</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/utilities/binary/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD PAIRING COMBINATIONS</button>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="product-table" class="table table-bordered">
			<thead>
				<tr>
					<th>POINT (L)</th>
					<th>POINT (R)</th>
					<th>INCOME</th>
					<th class="option-col"></th>
					<th class="option-col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($_pairing as $pairing)
				<tr>
					<td>{{ number_format($pairing->pairing_point_l, 2) }}</td>
					<td>{{ number_format($pairing->pairing_point_r, 2) }}</td>
					<td>{{ number_format($pairing->pairing_income, 2) }}</td>
					<td><a href="admin/utilities/binary/edit?id={{ $pairing->pairing_id }}">EDIT</a></td>
					<td><a href="admin/utilities/binary/delete?id={{ $pairing->pairing_id }}">DELETE</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-star-half-o"></i> MEMBERSHIP POINTS PER ENTRY</h2>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="product-table" class="table table-bordered">
			<thead>
				<tr>
					<th>MEMBERSHIP</th>
					<th>DISTRIBUTION POINTS</th>
					<th class="option-col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($_membership as $membership)
				<tr>
					<td>{{ $membership->membership_name }}</td>
					<td>{{ number_format($membership->membership_binary_points, 2) }}</td>
					<td><a href="">EDIT</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection