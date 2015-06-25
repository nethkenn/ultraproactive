@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> ACCOUNT / FIELD</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/accounts'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> BACK</button>
			</div>
		</div>
	</div>
	<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="text-center">Label</th>
						<th class="text-center">Field Type</th>
						<th class="text-center">Required</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@if($_account_field)
						@foreach($_account_field as $account_field)
							<tr>
								<td class="text-center">{{$account_field->account_field_label}}</td>
								<td class="text-center">{{$account_field->account_field_type}}</td>
								<td class="text-center"><input disabled="disabled"  {{ ( $account_field->account_field_required == 1 ? 'checked="checked"' : '' ) }}  type="checkbox"></td>
								<td class="text-center"><a href="admin/maintenance/accounts/field/delete?id={{ $account_field->account_field_id }}">DELETE</a></td>
							</tr>
						@endforeach
					@endif
					<form method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<tr>
							<td class="text-center"><input name="label" class="form-control text-center" type="textbox"></td>
							<td class="text-center">
								<select name="field-type" class="form-control text-center">
									<option>Textbox</option>
									<option>Textarea</option>
									<option>Option (Yes / No)</option>
								</select>
							</td>
							<td class="text-center"><input name="required" class="form-control" type="checkbox"></td>
							<td class="text-center"><input class="btn btn-primary" type="submit" value="ADD FIELD"></td>
						</tr>
					</form>
				</tbody>
			</table>
	</div>
@endsection