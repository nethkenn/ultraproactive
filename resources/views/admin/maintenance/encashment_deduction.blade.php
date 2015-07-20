@extends('admin.layout')
@section('content')


	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> DEDUCTIONS</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/deduction/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD DEDUCTIONS</button>
			</div>
			</div>
		</div>
		<div class="filters "></div>
	</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/maintenance/deduction">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/maintenance/deduction?archived=1">ARCHIVED</a>
			</div>
		</div>
	<div class="col-md-12">
		@if($deduction)
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Deduction Label</th>
						<th>Target Country</th>
						<th>Deduction Amount</th>
						<th class="option-col"></th>
						<th class="option-col"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($deduction as $d)
					<tr class="text-center">
						<td>{{ $d->deduction_label }}</td>
						<td>{{ $d->country_name == "" ? "All Country" : $d->country_name }}</td>
						<td>{{ $d->deduction_amount }}{{$d->percent == 1 ? "%" : ""}}</td>
						<td><a href="admin/maintenance/deduction/edit?id={{ $d->deduction_id }}">modify</a> </td>
						<td><a href="admin/maintenance/deduction/delete?id={{ $d->deduction_id }}">delete</a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
		<div class="col-md-12 text-center">
			No Data
		</div>
		@endif
	</div>
@endsection

@section('script')

@endsection
