@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<div class="title col-md-8">
				<h2><i class="fa fa-share-alt"></i> SLOTS</h2>
			</div>
			<div class="buttons col-md-2 text-right">
				<button class="slot_limit btn btn-primary" type="button" style="width: 100%;"><i></i>Slot Limit ({{$slot_limit->value}})</button>
			</div>
			<div class="buttons col-md-2 text-right">
				<button onclick="location.href='admin/maintenance/slots/add'" style="width: 100%;" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> GENERATE SLOTS</button>
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
						<th>Slot #</th>
						<th>Owner</th>
						<th>Membership</th>
						<th>Type</th>
{{-- 						<th>Wallet</th> --}}
						<th></th>
						<th></th>
					</tr>
				</thead>
			</table>
	</div>

<div class="remodal create-slot" data-remodal-id="slot_limit" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Slot Limit per account:
    </div>
    <form class="form-horizontal" method="POST">
	    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
	    <input type="number" class="form-control" value="{{$slot_limit->value}}" name="slot_limit" style="text-align: center;">
		<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Change Limit</button>
    </form>
</div>

@endsection

@section('script')
<script type="text/javascript">
$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        	        ajax:{
	        	url:'{{ url("admin/maintenance/slots/data") }}',
	        	data:{
	        	   	memid : "{{$memid = Request::input('memid')}}"
	        	   }
	    	},
        columns: [
            {data: 'slot_id', name: 'slot_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'membership_name', name: 'membership_name'},
            {data: 'slot_type', name: 'slot_type'},
            // {data: 'wallet', name: 'slot_wallet'},
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


    var mem  = '{!! Request::input("memid")  !!}';
  	var json = '{!! json_encode($membership) !!}';
  	json = $.parseJSON(json);
  	var str = '<select onchange="if (this.value) window.location.href=this.value" class="style form-control"><option value="/admin/maintenance/slots">All</option>';

  	$.each(json, function(key, val)
	{	
		if(mem == val.membership_id)
		{
			str = str + '<option value="/admin/maintenance/slots?memid='+val.membership_id+'" selected>'+val.membership_name+'</option>';			
		}
		else
		{
			str = str + '<option value="/admin/maintenance/slots?memid='+val.membership_id+'">'+val.membership_name+'</option>';
		}

	});

  	str = str + '</select>';
	$('#table_filter').prepend(str);
    $.fn.dataTableExt.sErrMode = 'throw';

    $(".slot_limit").click(function()
    {
			var inst = $('[data-remodal-id=slot_limit]').remodal();
          	inst.open(); 
    });


});
</script>
@endsection