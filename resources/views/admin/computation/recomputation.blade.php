@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> RECOMPUTATION</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button type="button" class="btn btn-primary start-computation"><i class="fa fa-cycle"></i> START RE-COMPUTATION</button>
			</div>
		</div>
		<div class="filters ">
			 <div class="col-md-8">
 			</div>
		</div>
	</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th class="option-col">Slot #</th>
						<th>Owner</th>
						<th>Membership</th>
						<th>Type</th>
						<th>Wallet</th>
						<th class="option-col">Left</th>
						<th class="option-col">Right</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@foreach($_account as $slot)
					<tr class="text-center ready-compute" slot_id="{{ $slot->slot_id }}">
						<td>{{ $slot->slot_id }}</td>
						<td>{{ $slot->account_name }}</td>
						<td>{{ $slot->membership_name }}</td>
						<td>{{ $slot->slot_type }}</td>
						<td>{{ $slot->slot_wallet }}</td>
						<td>{{ $slot->slot_binary_left }}</td>
						<td>{{ $slot->slot_binary_right }}</td>
						<td class="status">Pending</td>
					</tr>
					@endforeach
				</tbody>
			</table>
	</div>
@endsection

@section('script')
<script type="text/javascript">
var recompute = new recompute()
function recompute()
{
	init();
	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}
	function document_ready()
	{
		initialize_recompute_event();
	}
	function initialize_recompute_event()
	{
		$(".start-computation").click(function()
		{
			$.ajax({
				url:"admin/utilities/recompute?action=initialize",
				dataType:"json",
				type:"post",
				success: function(data)
				{
					if(data == "success")
					{
						compute();
					}
				}
			})
		});
	}
	function compute()
	{
		$target = $(".ready-compute:first");
		$target.removeClass("ready-compute");
		$slot_id = $target.attr("slot_id");


		var errorDiv = $target;
		var scrollPos = errorDiv.offset().top;
		$(window).scrollTop(scrollPos - 300);

		$.ajax({
			url:"admin/utilities/recompute?action=compute&slot_id=" + $slot_id,
			dataType:"json",
			type:"post",
			success: function(data)
			{
				$target.find(".status").html("<span style='color: green'>SUCCESS (" + $slot_id + ")</span>");
			},
			error: function(data)
			{
				$target.find(".status").html("<span style='color: red'>ERROR (" + $slot_id + ")</span>");
			},
			complete: function()
			{
				compute();
			}
		})
	}
}
</script>
@endsection