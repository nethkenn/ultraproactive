@extends('admin.layout')
@section('content')
<div>
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-teampaper-o"></i> team MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-2 text-right">
			<button onclick="location.href='admin/content/team/sort'" type="button" class="btn btn-primary">SORT TEAM</button>
		</div>
		<div class="buttons col-md-2 text-right">
			<button onclick="location.href='admin/content/team/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD TEAM</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
	{{-- <div class="filters ">
		<div class="col-md-8">
			<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/content/accounts/">ACTIVE</a>
			<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/content/accounts/?archived=1">ARCHIVED</a>
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
				<td><a href="admin/content/team/edit?id={{ $team->team_id }}">modify</a> | <a href="admin/content/team/delete?id={{ $team->team_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection