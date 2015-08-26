@extends('admin.layout')
@section('content')
<!-- PRODUCT -->
@if($category == "product")
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> FAQ PRODUCT</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/faq/add?type=product'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD FAQ</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Faq Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_product as $product)
			<tr class="text-center">
				<td>{{ $product->faq_title }}</td>
				<td><a href="admin/content/faq/edit?id={{ $product->faq_id }}&&type=product">modify</a> | <a href="admin/content/faq/delete?id={{ $product->faq_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<!-- MINDSYNC -->
@elseif($category == "mindsync")
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> FAQ MINDSYNC</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/faq/add?type=mindsync'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD FAQ</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Faq Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_mindsync as $mindsync)
			<tr class="text-center">
				<td>{{ $mindsync->faq_title }}</td>
				<td><a href="admin/content/faq/edit?id={{ $mindsync->faq_id }}&&type=mindsync">modify</a> | <a href="admin/content/faq/delete?id={{ $mindsync->faq_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<!-- OPPORTUNITY -->
@elseif($category == "opportunity")
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> FAQ OPPORTUNITY</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='admin/content/faq/add?type=opportunity'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD FAQ</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Faq Title</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($_opportunity as $opportunity)
			<tr class="text-center">
				<td>{{ $opportunity->faq_title }}</td>
				<td><a href="admin/content/faq/edit?id={{ $opportunity->faq_id }}&&type=opportunity">modify</a> | <a href="admin/content/faq/delete?id={{ $opportunity->faq_id }}">delete</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@else
<!-- INDEX -->
<div class="row">
	<div class="header" style="overflow: auto; clear:both;">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> FAQ SELECT</h2>
		</div>
	</div>
	<div class="contents row text-center">
		<div class="col-md-4">
			<a href="/admin/content/faq?type=product">
				<button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">PRODUCT</button>
			</a>
		</div>
		<div class="col-md-4">
			<a href="/admin/content/faq?type=mindsync">
				<button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">MINDSYNC</button>
			</a>
		</div>
		<div class="col-md-4">
			<a href="/admin/content/faq?type=opportunity">
				<button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">OPPORTUNITY</button>
			</a>
		</div>
	</div>
</div>
@endif
@endsection