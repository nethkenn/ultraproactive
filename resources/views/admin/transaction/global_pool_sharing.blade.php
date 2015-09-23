@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> Global Pool Sharing </h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<form method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="btn btn-primary" name="sbmt">Start Sharing</button> 
				<!--	<button type="button" class="btn btn-primary" id="histoir">History</button> -->
				</form>
			</div>
		</div>
	</div>
		<div class="col-md-12">
				<table id="table" class="table table-bordered">
					<thead>
						<tr class="text-center">
							<th>Global PV Sharing %</th>
							<th>Total PV</th>
							<th>Total Shared PV</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$gps}}</td>
							<td>{{$total_pv}}</td>
							<td>{{$shared}}</td>
						</tr>
					</tbody>
				</table>
		</div>


@endsection
@section('script')
@endsection
