@extends('admin.layout')
@section('content')
<!-- PRODUCT -->
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-cart-plus-o"></i> Item Packages</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='/admin/content/item_packages/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD ITEM PACKAGES</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Packages Title</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
			@if(count($_item_packages) > 0)
			@foreach($_item_packages as $item_packages)
			<tr class="text-center">
				<td>{{ $item_packages->item_package_title }}</td>
				<td><a href="admin/content/item_packages/add?id={{ $item_packages->item_package_id }}">modify</a> | <a href="admin/content/item_packages/delete?id={{ $item_packages->item_package_id }}">delete</a></td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="2" class="text-center">
					<strong>NO ITEM PACKAGES POSTED</strong>
				</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
@endsection