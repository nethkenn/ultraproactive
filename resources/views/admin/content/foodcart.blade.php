@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-cart"></i> FOODCART MANAGEMENT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/foodcart/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD FoodCart</button>
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
				<td>FoodCart ID</td>
				<td>FoodCart Title</td>
				<td>FoodCart Image</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_foodcart as $foodcart)
			<tr class="text-center">
				<td>{{ $foodcart->foodcart_id }}</td>
				<td>{{ $foodcart->foodcart_title }}</td>
				<td><a href="{{ $foodcart->image }}">{{ $foodcart->foodcart_image }}</a></td>
				<td><a href="admin/content/foodcart/edit?id={{ $foodcart->foodcart_id }}">modify</a> | <a href="admin/content/foodcart/delete?id={{ $foodcart->foodcart_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection