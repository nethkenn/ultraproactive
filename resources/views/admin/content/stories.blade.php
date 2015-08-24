@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-storiespaper-o"></i> Stories MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/stories/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD Stories</button>
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
				<th>Stories ID</th>
				<th>Stories Title</th>
				<th>Stories Link</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_stories as $stories)
			<tr class="text-center">
				<td>{{ $stories->stories_id }}</td>
				<td>{{ $stories->stories_title }}</td>
				<td>www.youtube.com/watch?v={{ $stories->stories_link }}</td>
				<td><a href="admin/content/stories/edit?id={{ $stories->stories_id }}">modify</a> | <a href="admin/content/stories/delete?id={{ $stories->stories_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection