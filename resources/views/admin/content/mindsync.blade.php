@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> MINDSYNC MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/mindsync/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD MINDSYNC</button>
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
				<td>MindSync ID</td>
				<td>MindSync Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_mindsync as $mindsync)
			<tr class="text-center">
				<td>{{ $mindsync->mindsync_id }}</td>
				<td>{{ $mindsync->mindsync_title }}</td>
				<td><a href="admin/content/mindsync/edit?id={{ $mindsync->mindsync_id }}">modify</a> | <a href="admin/content/mindsync/delete?id={{ $mindsync->mindsync_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection