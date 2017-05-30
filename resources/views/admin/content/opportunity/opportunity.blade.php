@extends('admin.layout')
@section('content')
<!-- PRODUCT -->
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-newspaper-o"></i> Opportunity</h2>
		</div>
		<div class="buttons col-md-4 text-right">
			<button onclick="location.href='/admin/content/opportunity/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD OPPORTUNITY</button>
		</div>
	</div>
	<div class="filters ">
	</div>
</div>
<div class="col-md-12">
	<table id="table" class="table table-bordered">
		<thead>
			<tr class="text-center">
				<td>Opportunity Title</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
			@if(count($_opportunity) > 0)
			@foreach($_opportunity as $opportunity)
			<tr class="text-center">
				<td>{{ $opportunity->opportunity_title }}</td>
				<td><a href="admin/content/opportunity/add?id={{ $opportunity->opportunity_id }}">modify</a> | <a href="admin/content/opportunity/delete?id={{ $opportunity->opportunity_id }}">delete</a></td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="2" class="text-center">
					<strong>NO OPPORTUNITY POSTED</strong>
				</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
@endsection