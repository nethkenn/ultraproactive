@extends('admin.layout')
@section('content')
<!-- HEADER -->
<input class="token" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Audit Trail</h2>
    </div>
</div>
	
<div class="form-container">
	@if($_logs)
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Admin Name</th>
						<th>Logs</th>
						<th>Date/Time</th>
						@if($admin_rank == 0)
						<th>View</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach($_logs as $logs)
					<tr>
						<td>{{$logs->account_name}}</td>
						<td>{!! $logs->logs!!}</td>
						<td>{!! $logs->created_at!!}</td>
						@if($admin_rank == 0)
						<td><a href='admin/reports/audit_trail/view?id={{$logs->admin_log_id}}' target="_blank">View</a></td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="pull-right">
				{!! $_logs->render() !!}
			</div>
	@endif	
</div>	

@endsection

@section('script')

@endsection