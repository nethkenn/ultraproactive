@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>Process Sale</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/transaction/sales'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button  type="button" class="btn btn-primary final-process-submit"><i class="fa fa-save "></i> Process Sale</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="process-sale-add-form" method="post" action="admin/transaction/sales/process/member">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      @if($errors->all())
	                <div class="form-group col-md-12 alert alert-danger">
	                		<ul>
	                			@foreach($errors->all() as $error)
	                				<li>{{$error}}</li>
	                			@endforeach
	                		</ul>
	                </div>
                @endif
            <div class="form-group col-md-12">
                <label for="recipient_type">Recipient Type</label>
                <select id="select-member-type" class="form-control" name="member_type">
                	<option value="0" {{Request::old('member_type') == 0 ? 'selected' : '' }}>Member</option>
                	<option value="1" {{Request::old('member_type') == 1 ? 'selected' : '' }}>Non-member</option>
                </select>
            </div>

            <div class="form-group col-md-12 for-member-input">
                <label for="account id">Member</label>
                @if($errors->get('account_id'))<span style="color:red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>@endif
                <select id="select-member" name="account_id" class="form-control">
                	<option value="">Select Member</option>
                	@foreach ($_member_account as $member_account)
						<option value="{{$member_account->account_id}}" {{Request::old('account_id') == $member_account->account_id ? 'selected' : '' }}>{{$member_account->account_name}} ( {{$member_account->account_username}} )</option>
					@endforeach
                </select>
            </div>
            <div class="form-group col-md-12 for-member-input">
                <label for="Slot">Slot</label>
                @if($errors->get('slot_id'))<span style="color:red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>@endif
                <select name="slot_id" id="select-slot" request-input="{{Request::old('slot_id')}}" class="form-control">
                	<option value="">Select Slot</option>
                </select>
            </div>
            <div class="form-group col-md-12 for-member-input">
                <label  for="">Voucher Status</label>
                                @if($errors->get('status'))<span style="color:red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>@endif

                <select id="select-status" name="status" class="form-control">
                	<option value="processed" {{Request::old('processed') == 'processed' ? 'selected' : '' }}>Processed</option>
                	<option value="unclaimed" {{Request::old('unclaimed') == 'unclaimed' ? 'selected' : '' }}>Unclaimed</option>
                </select>
            </div>
            
            <div class="form-group col-md-12 or-num">
                <label for="or number">OR number</label>
                <input type="text" name="or_number" class="form-control" value="{{Request::old('or_number')}}">
            </div>   

            <div class="form-group col-md-12 payment">
                <label for="payment-option">Payment Options</label>
                <select id="payment-option" name="payment_option" class="form-control">
                  <option value="0" {{Request::old('0') == '0' ? 'selected' : '' }}>Cash</option>
                  <option value="1" {{Request::old('1') == '1' ? 'selected' : '' }}>Credit Card (Additional 3% Other Charges)</option>
                </select>
            </div> 

            <div class="form-group col-md-12">
                <label for="account password">Password</label>
                                @if($errors->get('account_password'))<span style="color:red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>@endif
                <input class="form-control" type="password" name="account_password" value="">
            </div> 

            <div class="form-group col-md-12 charge">
                <label for="charge">Other Charge</label>
                <input type="checkbox" id="charge">
            </div> 

            <div class="form-group col-md-12 charged">

            </div> 
            
        </form>
    	<div class="form-group col-md-12">
    		<label for=""><strong>Product List</strong></label>
			<table id="product-table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>SKU</th>
						<th>Name</th>
						<th>Unilevel PTS</th>
						<th>Binary PTS</th>
						<th>Price</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div class="form-group col-md-12">
			<label for=""><strong>Cart List</strong></label>
			<table id="product-cart" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>SKU</th>
						<th>Name</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody id="cart-container">

				</tbody>
			</table>
		</div>
   	</div>



<div class="remodal" data-remodal-id="add-product-modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false"> 
  <button data-remodal-action="close" class="remodal-close"></button>
  <form id="add-product-modal" class="form-horizontal">
  <div class="form-group">
  	<h3>Add Quantity</h3>
    <label for="inputPassword3" class="col-sm-2 control-label">Quantity</label>
    <div class="col-sm-10">
      <input id="product-id-input" type="hidden" name="product_id" value="">
      <input type="number" name="qty" class="form-control" id="" placeholder="Enter quantity">
    </div>
  </div>
</form>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button  class="remodal-confirm" id="submit-product">OK</button>
</div>


<div class="remodal" data-remodal-id="edit-product-modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false"> 
  <button data-remodal-action="close" class="remodal-close"></button>
  <form id="edit-product-modal" class="form-horizontal">
  <div class="form-group">
  	<h3>Edit Quantity</h3>
    <label for="inputPassword3" class="col-sm-2 control-label">Quantity</label>
    <div class="col-sm-10">
      <input id="edit-product-id-input" type="hidden" name="product_id" value="">
      <input type="number" name="qty" class="form-control" id="" placeholder="Enter quantity">
    </div>
  </div>
</form>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button  class="remodal-confirm" id="edit-submit-product">OK</button>
</div>
@endsection
@section('script')
	<script type="text/javascript">


	$(document).ready(function()
	{

			var $productTable = $('#product-table').DataTable(
			{

	        processing: true,
	        serverSide: true,
	        ajax:{
	        	url:'admin/maintenance/product_package/get_product',
	    	},

	        columns: [
	            {data: 'product_id', name: 'product_id'},
	            {data: 'sku', name: 'sku'},
	            {data: 'product_name', name: 'product_name'},
	            {data: 'unilevel_pts', name: 'unilevel_pts'},
	            {data: 'binary_pts' ,name: 'binary_pts'},
	            {data: 'price' ,name: 'price'},
	           	{data: 'add' ,name: 'product_id'}
	            
	           	
	        ],
	        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
	        "oLanguage": 
	        	{
	        		"sSearch": "",
	        		"sProcessing": ""
	         	},
	        stateSave: true,
	    });



	});
	</script>
	<script type="text/javascript" src="resources/assets/admin/process_sale.js"></script>
@endsection