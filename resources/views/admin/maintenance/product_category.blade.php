@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-flag-checkered"></i> Product Category MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/maintenance/product_category/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD Product Category</button>
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
				<td>Category ID</td>
				<td>Category Name</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_product_category as $product_category)
			<tr class="text-center">
				<td>{{ $product_category->product_category_id }}</td>
				<td>{{ $product_category->product_category_name }}</td>
				<td><a href="admin/maintenance/product_category/edit?id={{ $product_category->product_category_id }}">modify</a> | <a href="admin/maintenance/product_category/delete?id={{ $product_category->product_category_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection