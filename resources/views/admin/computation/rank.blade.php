@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-star-half-o"></i> PROMOTION SETTINGS</h2>
		</div>
	</div>
</div>
<div class="col-md-12">
	<table id="product-table" class="table table-bordered">
		<thead>
			<tr>
				<th class="option-col">ID</th>
				<th>MEMBERSHIP</th>
				<th>REQUIRED COUNT</th>
				<th>REQUIRED GROUP PV SALES</th>
				<th>REQUIRED MONTHS MAINTAINED IN UNILEVEL</th>
				<th>ENABLE PROMOTION</th>
				<th class="option-col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_membership as $membership)
			<tr>
				<td>{{ $membership->membership_id }}</td>
				<td>{{ $membership->membership_name }}</td>
				<td>{{ $membership->membership_required_direct }} {{$membership->membership_required_unilevel_leg == 1 ? "Different Unilevel Legs Direct/Indirect Counts ($membership->required_leg)" : "Direct Counts"}}</td>
				<td>{{ number_format($membership->membership_required_pv_sales, 2) }}</td>
				<td>{{ $membership->membership_required_month_count }}</td>
				<td><input disabled="disabled" type="checkbox" {{ $membership->upgrade_via_points == 1 ? 'checked' : '' }}></td>
				<td><a href="admin/utilities/rank/edit?id={{ $membership->membership_id }}">EDIT</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection

