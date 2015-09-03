@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-user-secret"></i> POSITION</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/utilities/position/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD POSITION</button>
			</div>
			@if($allow == 0)
            <div class="buttons col-md-4 text-right">
                <button class="slot_limit btn btn-primary" type="button" style="width: 100%;"><i></i>Access for Update Slot</button>
            </div>
            @endif
		</div>
		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('archived') ? '' : 'active' }}" href="admin/utilities/position">ACTIVE</a>
				<a class="{{$active = Request::input('archived') ? 'active' : '' }}" href="admin/utilities/position?archived=1">ARCHIVED</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<table id="postion-table" class="table table-bordered">
			<thead>
				<tr>
					<th>Position ID</th>
					<th>Position Name</th>
					<th>Position Level</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="remodal create-slot" data-remodal-id="slot_limit" data-remodal-options="hashTracking: false">
	    <button data-remodal-action="close" class="remodal-close"></button>
	    <div class="header">
	        Username that can allow to update the slot.
	    </div>
	    <form class="form-horizontal" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="text" name="allow_button" value="{{$allow_button}}" class="form-control">
	    </form>
	</div>

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function()
		{
			var $positionTable = $('#postion-table').DataTable(
			{
		        processing: true,
		        serverSide: true,
		        ajax:{
		        	url:'admin/utilities/position/data',
		        	data:{
		        	   	archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
		        	   }
		    	},

		        columns: [
		            { data: 'admin_position_id', name: 'admin_position_id'},
		            { data: 'admin_position_name', name: 'admin_position_name'},
		            { data: 'admin_position_rank', name: 'admin_position_rank'},
		            { data: 'edit' ,name: 'admin_position_id'},
		            { data: 'archive' ,name: 'admin_position_id'}
		        ],
		        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
		        "oLanguage": 
		        	{
		        		"sSearch": "",
		        		"sProcessing": ""
		         	},
		        stateSave: true,
	    	});


			$('#postion-table').on('click', '.archived-position', function(event)
			{
				event.preventDefault();
				var $token  = $('input[name="_token"]').val();
				var $id = $(this).attr('position-id');
				// console.log($token);
				// console.log($id);
				event.preventDefault();

				$.ajax({
					url: 'admin/utilities/position/delete',
					type: 'post',
					dataType: 'json',
					data: {admin_position_id: $id,
							_token : $token
							},
				})
				.done(function(data) {
					console.log(data);
					$positionTable.draw();
				})
				.fail(function() {
					// console.log("error");
					alert("Error on archiving position");
				})
				.always(function() {
					console.log("complete");
				});
			})


			$('#postion-table').on('click', '.restore-position', function(event)
			{
				event.preventDefault();
				var $token  = $('input[name="_token"]').val();
				var $id = $(this).attr('position-id');
				// console.log($token);
				// console.log($id);
				event.preventDefault();

				$.ajax({
					url: 'admin/utilities/position/restore',
					type: 'post',
					dataType: 'json',
					data: {admin_position_id: $id,
							_token : $token
							},
				})
				.done(function(data) {
					console.log(data);
					$positionTable.draw();
				})
				.fail(function() {
					// console.log("error");
					alert("Error on restoring position");
				})
				.always(function() {
					console.log("complete");
				});
			})





					
		});
	</script>
@endsection
@endsection
