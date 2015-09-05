@extends('admin.layout')
@section('content')
<!-- TESTIMONY -->
@if($category == "testimony")
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> MINDSYNC TESTIMONY</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/mindsync/testimony/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD TESTIMONY</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Testimony Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_mindsync as $mindsync)
			<tr class="text-center">
				<td>{{ $mindsync->mindsync_title }}</td>
				<td><a href="admin/content/mindsync/testimony/edit?id={{ $mindsync->mindsync_id }}">modify</a> | <a href="admin/content/mindsync/testimony/delete?id={{ $mindsync->mindsync_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif
<!-- IMAGE -->
@if($category == "image")
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> MINDSYNC IMAGE</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/mindsync/image/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD IMAGE</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Image</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_mindsync as $mindsync)
			<tr class="text-center">
				<td><a href="{{ $mindsync->image }}">Image Link</a></td>
				<td><a href="admin/content/mindsync/image/edit?id={{ $mindsync->mindsync_id }}">modify</a> | <a href="admin/content/mindsync/image/delete?id={{ $mindsync->mindsync_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif
<!-- VIDEO -->
@if($category == "video")
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> MINDSYNC VIDEO</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/mindsync/video/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD VIDEO</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Video Link</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_mindsync as $mindsync)
			<tr class="text-center">
				<td>https://www.youtube.com/watch?v={{ $mindsync->mindsync_video }}</td>
				<td><a href="admin/content/mindsync/video/edit?id={{ $mindsync->mindsync_id }}">modify</a> | <a href="admin/content/mindsync/video/delete?id={{ $mindsync->mindsync_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif
<!-- INDEX -->
@if($category == "index")
<div class="row">
	<div class="header" style="overflow: auto; clear:both;">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> MINDSYNC SELECT</h2>
		</div>
	</div>
	<div class="contents row text-center">
		<div class="col-md-4">
			<a href="/admin/content/mindsync/video">
				<button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">VIDEO</button>
			</a>
		</div>
		<div class="col-md-4">
			<a href="/admin/content/mindsync/image">
				<button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">IMAGE</button>
			</a>
		</div>
		<div class="col-md-4">
			<a href="/admin/content/mindsync/testimony">
				<button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">TESTIMONY</button>
			</a>
		</div>
	</div>
</div>
@endif
@endsection