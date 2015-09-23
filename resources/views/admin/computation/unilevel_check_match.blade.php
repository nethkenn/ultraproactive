@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-star-half-o"></i> UNILEVEL CHECK MATCH</h2>
		</div>
	</div>
</div>
<div class="col-md-12">
	<table id="product-table" class="table table-bordered">
		<thead>
			<tr>
				<th class="option-col">ID</th>
				<th>MEMBERSHIP</th>
				<th>NUMBER OF LEVELS</th>
				<th class="option-col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_membership as $membership)
			<tr>
				<td>{{ $membership->membership_id }}</td>
				<td>{{ $membership->membership_name }}</td>
				<td>{{ number_format($membership->check_match_level) }}</td>
				<td><a href="admin/utilities/unilevel_check_match/edit?id={{ $membership->membership_id }}">EDIT</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection