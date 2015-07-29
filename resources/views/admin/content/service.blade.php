@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-briefcase"></i> Service MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/service/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD Service</button>
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
				<td>Service ID</td>
				<td>Service Image</td>
				<td>Service Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_service as $service)
			<tr class="text-center">
				<td>{{ $service->service_id }}</td>
				<td><a href="{{ $service->image }}">{{ $service->service_image }}</a></td>
				<td>{{ $service->service_title }}</td>
				<td><a href="admin/content/service/edit?id={{ $service->service_id }}">modify</a> | <a href="admin/content/service/delete?id={{ $service->service_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection