@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> EARN MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/maintenance/earn/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD EARN</button>
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
				<td>Earn ID</td>
				<td>Earn Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_earn as $earn)
			<tr class="text-center">
				<td>{{ $earn->earn_id }}</td>
				<td>{{ $earn->earn_title }}</td>
				<td><a href="admin/maintenance/earn/edit?id={{ $earn->earn_id }}">modify</a> | <a href="admin/maintenance/earn/delete?id={{ $earn->earn_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection