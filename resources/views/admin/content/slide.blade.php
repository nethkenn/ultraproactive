@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-sliders"></i> SLIDE MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/slide/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD SLIDE</button>
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
				<td>Slide ID</td>
				<td>Slide Image</td>
				<td>Slide Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_slide as $slide)
			<tr class="text-center">
				<td>{{ $slide->slide_id }}</td>
				<td><a href="{{ $slide->image }}">{{ $slide->slide_image }}</a></td>
				<td>{{ $slide->slide_title }}</td>
				<td><a href="admin/content/slide/edit?id={{ $slide->slide_id }}">modify</a> | <a href="admin/content/slide/delete?id={{ $slide->slide_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection