@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-star-half-o"></i> COMPENSATION RANK SETTINGS</h2>
		</div>
	</div>
</div>
<div class="col-md-12">
	<table id="product-table" class="table table-bordered">
		<thead>
			<tr>
				<th>Compensation Rank</th>
				<th>Required Group UPcoins</th>
				<th>Required Personal UPcoins</th>
				<th>Required Personal UPcoins Maintenance</th>
				<th>Max Pairing</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_compensation as $compensation)
			<tr>
				<td>{{ $compensation->compensation_rank_name }}</td>
				<td>{{ $compensation->required_group_pv }}</td>
				<td>{{ $compensation->required_personal_pv }}</td>
				<td>{{ $compensation->required_personal_pv_maintenance }}</td>
				<td>{{ $compensation->rank_max_pairing }}</td>
				<td><a href="admin/utilities/rank/compensation/edit?id={{ $compensation->compensation_rank_id }}">EDIT</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection

