@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> Global Pool Sharing </h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<form method="POST">
					<button class="slot_limit btn btn-primary" type="button">Settings</button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				@if($settings_for_global->value == "Auto")	
					<button type="button" class="btn btn-primary" name="sbmt" disabled>Sharing is automatic</button>
				@elseif($total_pv == 0)
					<button type="button" class="btn btn-primary" name="sbmt" disabled>Nothing to share</button>
				@elseif($check->value == 0)	
					<button type="submit" class="btn btn-primary" name="sbmt">Start Sharing</button> 
				@else
				    <button type="button" class="btn btn-primary" name="sbmt" disabled>Still Processing</button>
				@endif
				<!--	<button type="button" class="btn btn-primary" id="histoir">History</button> -->
				</form>
			</div>
		</div>
	</div>
		<div class="col-md-12">
				<table id="table" class="table table-bordered">
					<thead>
						<tr class="text-center">
							<th>Global UPcoins Sharing %</th>
							<th>Total UPcoins</th>
							<th>Total Shared UPcoins</th>
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

<div class="remodal create-slot" data-remodal-id="slot_limit" data-remodal-options="hashTracking: false">
	    <button data-remodal-action="close" class="remodal-close"></button>
	    <div class="header">
	        Username that can allow to update the slot.
	    </div>
	    <form class="form-horizontal" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<select class="form-control" name="settings_for_global">
					<option value="Manual" {{$settings_for_global->value == "Manual" ? "selected" : ""}}>Manual</option>
					<option value="Auto" {{$settings_for_global->value == "Auto" ? "selected" : ""}}>Auto every last month</option>
				</select>
				<button type="submit" class="form-control">Save</button>
	    </form>
</div>
	     
@endsection
@section('script')
<script type="text/javascript">
  $(".slot_limit").click(function(){
	       		var inst = $('[data-remodal-id=slot_limit]').remodal();
	          	inst.open(); 
	       });
</script>
@endsection
