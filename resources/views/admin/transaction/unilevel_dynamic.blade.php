@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> Dynamic Compression</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<form method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				@if($check->value == 0)	
					<button type="submit" class="btn btn-primary" name="sbmt">Distribute Dynamically</button> 
				@else
				    <button type="button" class="btn btn-primary" name="sbmt" disabled>Still Processing</button>
				@endif
				<!--	<button type="button" class="btn btn-primary" id="histoir">History</button> -->
				</form>
			</div>
		</div>
		<div class="filters ">
			@if($last_update)
			 <div class="col-md-8">
			 				Last Update: {{$last_update->created_at}}
 			</div>
 			@endif
		</div>
	</div>
@if($slot)	
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Slot #</th>
						<th>Owner</th>
						<th>Personal PV</th>
						<th>Borrowed PV</th>
						<th>Total PV</th>
						<th>Group PV</th>
						<th>Multiplier</th>
						<th>Group PV to Wallet</th>
					</tr>
				</thead>
				<tbody>
					@foreach($slot as $s)
					<tr>
						<td>{{$s->slot_id}}</td>
						<td>{{$s->account_name}}</td>
						<td>{{$s->slot_personal_points}}</td>
						<td>{{$s->gained_pv - $s->slot_personal_points}}</td>
						<td>{{$s->gained_pv}}</td>
						<td>{{$s->slot_group_points}}</td>
						<td>{{$s->multiplier}}</td>
						<td>{{$s->slot_group_points * $s->multiplier}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
	</div>
@endif


<div class="remodal create-slot" data-remodal-id="history">
	<div class="col-md-12">
		@if($history)
		<table id="product-table" class="table table-bordered">
			<thead>
				<tr>
					<th>Slot ID</th>
					<th>Group PV</th>
					<th>Convert Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($history as $h)
				<tr>
					<th>{{$h->slot_id}}</th>
					<th>{{$h->group_points}}</th>
					<th>{{$h->convert_amount}}</th>
				</tr>	
				@endforeach
			</tbody>
		</table>
		@else
		No History
		@endif
	</div>
</div>


@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".level-input").keyup(function(e)
        {
            $val = $(e.currentTarget).val();
            $(".level-container").html('');
            for($ctr = 0; $ctr < $val; $ctr++)
            {
                $level = $ctr + 1;
                $(".level-container").append(   '<div class="form-group col-md-12">' +
                                                    '<label for="account_contact">Level ' + $level + ' (0-100%)</label>' +
                                                    '<input name="level[' + $level + ']" value="0" required="required" class="form-control" id="" placeholder="" type="text">' +
                                                '</div>');
            }
        });
    });
</script>
@endsection
