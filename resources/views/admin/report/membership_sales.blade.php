@extends('admin.layout')
@section('content')
<!-- HEADER -->
<input class="token" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Membership Generate Reports</h2>
    </div>
</div>
<div class="form-container">
    <form id="add-product-form" method="post">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
       
        <div class="form-group-container">
        	 <!--HEADER FILTER -->
			<div class="filters">
				<div class="col-md-3">
					<select name="report-source" class="form-control">
						<option value="sales">SALES REPORT</option>
						{{-- <option values"sales-location">SALES PER LOCATION</option> --}}
					</select>
				</div>
				<div class="col-md-3">
					<select name="group-date" class="form-control">
						<option {{ $group == "daily" ? "selected='selected'" : '' }} value ="daily">DAILY</option>
						<option {{ $group == "monthly" ? "selected='selected'" : '' }} value ="monthly">MONTHLY</option>
						<option {{ $group == "yearly" ? "selected='selected'" : '' }} value ="yearly">YEARLY</option>
					</select>
				</div>
				<div class="col-md-2">
					<input type="text" placeholder="From" name="from" value="{{ $from }}" class="form-control datepicker">
				</div>
				<div class="col-md-2">
					<input type="text" placeholder="To" name="to" value="{{ $to }}"  class="form-control datepicker">
				</div>
				<div class="col-md-2">
					<button class="btn btn-primary"><i class="fa fa-area-chart"></i> Generate Report</button>
				</div>
			</div>
			<div class="graph-container" style="min-height: 300px; margin-top: 40px;"></div>
			<div class="col-md-12" style="margin-top: 30px">
			    <table id="data-table" class="table table-bordered data-table">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Value</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<?php foreach($_report as $report): ?>
			        	<tr>
			        		<td>{{ $report["date"] }}</td>
			        		<td>{{ $report["income"] }}</td>
			        	</tr>
			        	<?php endforeach; ?>
			        </tbody>
			    </table>
			</div>


    	</div>
    </form>
</div>	

@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="resources/assets/jquery-ui/jquery-ui.css">
<script type="text/javascript" src="resources/assets/jquery-ui/jquery-ui.min.js"></script>
<script src="resources/assets/external/highchart.js"></script>
<script src="resources/assets/external/modules/exporting.js"></script>
<script type="text/javascript">

	var analytics = '{!! json_encode($_report) !!}';




</script>
<script type="text/javascript" src="resources/assets/admin/report.js"></script>
@endsection