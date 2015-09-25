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
					</tr>
				</thead>
				<tbody>
					@foreach($_logs as $logs)
					<tr>
						<td>{{$logs->account_name}}</td>
						<td>{!! $logs->logs!!}</td>
						<td>{!! $logs->created_at!!}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
	@endif	
</div>	

@endsection

@section('script')

@endsection