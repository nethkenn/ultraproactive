@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-book"></i> TESTIMONY MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/maintenance/testimony/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD Testimony</button>
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
				<td>Testimony ID</td>
				<td>Testimony Text</td>
				<td>Testimony Person</td>
				<td>Testimony Position</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_testimony as $testimony)
			<tr class="text-center">
				<td>{{ $testimony->testimony_id }}</td>
				<td>{{ substr($testimony->testimony_text, 0, 50) }}...</td>
				<td>{{ $testimony->testimony_person }}</td>
				<td>{{ $testimony->testimony_position }}</td>
				<td><a href="admin/maintenance/testimony/edit?id={{ $testimony->testimony_id }}">modify</a> | <a href="admin/maintenance/testimony/delete?id={{ $testimony->testimony_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection