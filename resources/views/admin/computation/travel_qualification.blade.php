@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-star-half-o"></i> TRAVEL QUALIFICATION</h2>
		</div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/travel_qualification/add'" type="button" class="btn btn-primary">Add Qualification</button>
        </div>
	</div>
	<div class="filters ">
		<div class="col-md-8">
			<a class="{{$active = Request::input('status') ? '' : 'active' }}" href="admin/utilities/travel_qualification/">ACTIVE</a>
			<a class="{{$active = Request::input('status') ? 'active' : '' }}" href="admin/utilities/travel_qualification?status=archived">ARCHIVED</a>
		</div>
	</div>
</div>
<div class="col-md-12">
	<table id="product-table" class="table table-bordered">
		<thead>
			<tr>
				<th class="option-col">ID</th>
				<th>TRAVEL QUALIFICATION</th>
				<th>ITEM</th>
				<th>POINTS</th>
				<th class="option-col"></th>
				<th class="option-col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_qualification as $qualification)
			<tr>
				<td>{{ $qualification->travel_qualification_id }}</td>
				<td>{{ $qualification->travel_qualification_name }}</td>
				<td>{{ $qualification->item }}</td>
				<td>{{ $qualification->points }}</td>
				<td><a href="admin/utilities/travel_qualification/edit?id={{ $qualification->travel_qualification_id }}">EDIT</a></td>
				@if(Request::input('status') == 'archived')
				<td><a href="admin/utilities/travel_qualification/restore?id={{ $qualification->travel_qualification_id }}">RESTORE</a></td>
				@else
				<td><a href="admin/utilities/travel_qualification/delete?id={{ $qualification->travel_qualification_id }}">ARCHIVE</a></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection

