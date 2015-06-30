@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" class="_token" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-level-up"></i> RANKING</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/ranking/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> ADD RANKING</button>
			</div>
		</div>
		<div class="filters ">
		</div>
	</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th class="option-col">ID</th>
						<th>Rank Name</th>
						<th>Rank Level</th>
						<th class="option-col"></th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
    var $rankingTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("admin/maintenance/ranking/data") }}',
        columns: [
            {data: 'rank_id', name: 'rank_id'},
            {data: 'rank_name', name: 'rank_name'},
            {data: 'rank_level', name: 'rank_level'},
            {data: 'edit', name: 'rank_id'},
            {data: 'delete', name: 'rank_id'},
        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{
        		"sSearch": "",
        		"sProcessing": ""
         	},
        stateSave: true,
    });

    	$rankingTable.on( 'draw.dt', function ()
    	{
			// init_archive_account();
			// init_restore_account();

			$('.delete-ranking').on('click', function(event)
			{
				event.preventDefault();
				var $this = $(this);
				var $token = $('._token').val();
				var $id =  $this.attr('rank-id');
				// console.log($('._token').val());
				// console.log($this.attr('rank-id'));

				// alert('test test test test test');

				var r = confirm("Delete ranking?");
				if (r == true)
				{
				  
					var ajax = $.ajax(
					{
						url: 'admin/maintenance/ranking/delete',
						type: 'post',
						dataType: 'json',
						data: {_token: $token,
								rank_id: $id 
								},
					})

					ajax.done(function(data)
					{
						console.log(data);
						if(data==true)
						{
							$rankingTable.draw();
						}

					})
					ajax.fail(function()
					{
						// console.log("error");
						alert("Opps! Something went wrong while deleting rankings")
					})
					ajax.always(function()
					{
						// console.log("complete");
					});


				}
				
			});
		})


});







</script>
@endsection