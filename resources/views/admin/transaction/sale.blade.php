@extends('admin.layout')
@section('content')
	<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> Sales </h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<button onclick="location.href='admin/transaction/sales/process'" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Process Sales</button>
			</div>
		</div> 
		<div class="filters ">

		</div>
	</div>
		<div class="filters col-md-12">
			@if(Session::get('success_message'))
				<div class="col-md-12 alert alert-success success-message">
					{{Session::get('success_message')}}
				</div>
			@endif
			<div class="col-md-8">
				<a class="{{Request::input('filter') == 'today' ? 'active' : '' }}" href="admin/transaction/sales?filter=today">Today's Sale</a>
				<a class="{{Request::input('filter') == null ? 'active' : '' }}" href="admin/transaction/sales">All Sale</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr class="text-center">

						<th >ID</th>
						<th>OR No</th>
						<th>Recipient Type </th>
						<th style="width:150px;">Recipient Name </th>
						<th>Sale Amount </th>
						<th>Processed By</th>
						<th>Date </th>
						<th>Status </th>
            <th>Payment Option </th>
						<th></th>
						{{-- <th style="width:200px;" class="option-col"></th> --}}
					</tr>
				</thead>
			</table>
	</div><div class="col-md-12">
	<button class="btn btn-primary " >Print</button>
	<button class="btn btn-primary email-voccher">Email</button>
</div>
<div class="remodal" data-remodal-id="view_prod_modal"
  data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div id="voucher-prod-container">

  </div>
  <div style="display:none;" id="email-message"></div>
  <button  data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button  class="print-voucher remodal-confirm">Print</button>
  <button  class="email-voucher remodal-confirm">Email</button>
  <img class="loading" style="display: none;" src="/resources/assets/img/small-loading.GIF" alt="">
</div>
<style type="text/css">
	
	@media print {
/*		body * {
			visibility: hidden;
		}
		#voucher-prod-containert, #voucher-prod-container * {
			visibility: visible;
		}
		#voucher-prod-containert{

			position: absolute;
			left: 0;
			right: 0;
			bottom: 0;
			top: 0;
			overflow: hidden;
	}*/
}
	</style>
@endsection

@section('script')

<script type="text/javascript" src="/resources/assets/admin/jQuery.print.js"></script>
<script type="text/javascript">
$(function() {

   $table = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
	        	url:'admin/transaction/sales/data',
	        	data: {filter: '{{Request::input("filter")}}'}

	    	},
        columns: [
            {data: 'voucher_id', name: 'voucher_id'},
            {data: 'or_number', name: 'or_number'},
            {data: 'account_id', name: 'account_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'processed_by_name', name: 'processed_by_name'},
            {data: 'updated_at', name: 'updated_at'},        
            {data: 'status', name: 'status'},
            {data: 'option', name: 'payment_option'},
            {data: 'test', name: 'voucher_id'},

		 ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
        	{
        		"sSearch": "",
        		"sProcessing": ""
         	},
        stateSave: true,
    });

   var modal = $('[data-remodal-id="view_prod_modal"]').remodal();

   $('#table').on('click', '.view-voucher', function(event) {
   		event.preventDefault();
   		var v_id = $(this).attr('voucher-id');
   		$('.email-voucher').attr('voucher-id', v_id);
   		$('#voucher-prod-container').load('admin/transaction/sales/process/sale_or?voucher_id='+v_id);
   		modal.open();
   });


   $('.print-voucher').on('click', function(event)
   {	
   		event.preventDefault();
   		
      w=window.open();
      w.document.write($('#voucher-prod-container').html());
      w.print();
      w.close();
       // $("body *:not(#voucher-prod-container)").css('display', 'none');
       // window.print(); 
      // 

   });


   $('.email-voucher').on('click', function(event)
   {

   		event.preventDefault();
   		var voucher_id = $(this).attr('voucher-id');

   		$('.loading').fadeIn();
   		$('#email-message').fadeOut();
   		$.ajax({
   			url: 'admin/transaction/sales/process/sale_or',
   			type: 'post',
   			dataType: 'json',
   			data: {voucher_id: voucher_id},
   		})
   		.done(function(data) {
   			
   			$('#email-message').empty();
   			$('#email-message').removeAttr('class');

   			var func = function(){
   				$('.loading').fadeOut();
   				if(data)
   				{	
   					$('#email-message').addClass('alert alert-success');
   					$('#email-message').html('Email successfully sent to ' + data + '.');
   					$('#email-message').fadeIn();
   				}
   				else
   				{
   					$('#email-message').addClass('alert alert-danger');
   					$('#email-message').html('Email sending failed.');
   					$('#email-message').fadeIn();
   				}
   			}

   			setTimeout(func, 1000);
   			
   		})
   		.fail(function() {

   			alert('Error on sendning email.');
   			// console.log("error");s
   		})
   		.always(function() {
   			// console.log("complete");
   		});
   		
   })



});
</script>
@endsection