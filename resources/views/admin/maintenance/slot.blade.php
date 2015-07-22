@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> SLOTS</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/maintenance/slots/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> GENERATE SLOTS</button>
			</div>
		</div>
		<div class="filters ">
		</div>
	</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Slot #</th>
						<th>Owner</th>
						<th>Membership</th>
						<th>Type</th>
						<th>Wallet</th>
						<th>Rank</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
			</table>
	</div>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("admin/maintenance/slots/data") }}',
        columns: [
            {data: 'slot_id', name: 'slot_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'membership_name', name: 'membership_name'},
            {data: 'slot_type', name: 'slot_type'},
            {data: 'wallet', name: 'slot_wallet'},
            {data: 'rank_name', name: 'rank_name'},
            {data: 'gen', name: 'slot_id'},
            {data: 'info', name: 'slot_id'},
        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{
        		"sSearch": "",
        		"sProcessing": ""
         	},
        stateSave: true,
    });

    $.fn.dataTableExt.sErrMode = 'throw';
});
</script>
@endsection