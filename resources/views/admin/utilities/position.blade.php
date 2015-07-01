@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-globe"></i> ADMIN POSITION</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/utilities/position/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD NEW POSITION</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
	{{-- <div class="filters ">
		<div class="col-md-8">
			<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/maintenance/accounts/">ACTIVE</a>
			<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/maintenance/accounts/?archived=1">ARCHIVED</a>
		</div>
	</div> --}}
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Position ID</td>
				<td>Position Name</td>
				<td>Position Level</td>
				<td>Number of Modules Access</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_position as $position)
			<tr class="text-center">
				<td>{{ $position->admin_position_id }}</td>
				<td>{{ $position->admin_position_name }}</td>
				<td>{{ $position->admin_position_rank }}</td>
				<td>{{ $position->modules}}</td>
				<td></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection