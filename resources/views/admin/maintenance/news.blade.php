@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> NEWS MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/maintenance/news/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD NEWS</button>
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
				<td>News ID</td>
				<td>News Image</td>
				<td>News Title</td>
				<td>News Date</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_news as $news)
			<tr class="text-center">
				<td>{{ $news->news_id }}</td>
				<td><a href="{{ $news->image }}">{{ $news->news_image }}</a></td>
				<td>{{ $news->news_title }}</td>
				<td>{{ $news->news_date }}</td>
				<td><a href="admin/maintenance/news/edit?id={{ $news->news_id }}">modify</a> | <a href="admin/maintenance/news/delete?id={{ $news->news_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection