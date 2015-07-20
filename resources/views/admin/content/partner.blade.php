@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-user-plus"></i> PARTNER MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/partner/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD partner</button>
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
				<td>Partner ID</td>
				<td>Partner Image</td>
				<td>Partner Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_partner as $partner)
			<tr class="text-center">
				<td>{{ $partner->partner_id }}</td>
				<td><a href="{{ $partner->image }}">{{ $partner->partner_image }}</a></td>
				<td>{{ $partner->partner_title }}</td>
				<td><a href="admin/content/partner/edit?id={{ $partner->partner_id }}">modify</a> | <a href="admin/content/partner/delete?id={{ $partner->partner_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection