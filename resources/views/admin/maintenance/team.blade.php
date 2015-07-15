@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-teampaper-o"></i> team MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/maintenance/team/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD team</button>
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
				<th>Team ID</th>
				<th>Team Image</th>
				<th>Team Name</th>
				<th>Team Role</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_team as $team)
			<tr class="text-center">
				<td>{{ $team->team_id }}</td>
				<td><a href="{{ $team->image }}">{{ $team->team_image }}</a></td>
				<td>{{ $team->team_title }}</td>
				<td>{{ $team->team_role }}</td>
				<td><a href="admin/maintenance/team/edit?id={{ $team->team_id }}">modify</a> | <a href="admin/maintenance/team/delete?id={{ $team->team_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection