@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Generate New Code</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/codes'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#code-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Generate</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="code-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-12">
                    <table class="tbl-code-cart table table-bordered">
                        <caption><h4>Cart</h4></caption>
                        <thead>
                            <tr>
                                <th>Membership ID</th>
                                <th>Membership Name</th>
                                <th>Product Package Name</th>
                                <th>Qty</th>
                                <th>Membership Price</th>
                                <th>Sub Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
                @if($errors->all())
                    <div class="form-group col-md-12">
                        <ul class="text-danger">
                            @foreach($errors->all() as $err)
                                <li>{{$err}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="form-group col-md-12">
                        <label for="Order Form Number">Order form Number</label>
                        <input type="text" name="order_form_number" class="form-control" value="{{Request::old('order_form_number')}}"> 
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Tendered Payment">Tendered Payment</label>
                        <input type="number" name="tendered_payment" class="form-control" value="{{Request::old('tendered_payment')}}"> 
                    </div>
                    <div class="form-group col-md-12">
                		<label for="membership">Membership</label>
                        <select name="membership_id" class="form-control selected-membership-id">
                            @if($_membership)
                                @foreach($_membership as $membership)
                                    <option {{Request::old('membership_id') == $membership->membership_id ? 'selected' : ''}} value="{{$membership->membership_id}}"}>{{$membership->membership_name}}</option>
                                @endforeach
                            @endif
                        </select>
                	</div>
                    <div class="form-group col-md-12">
                        <label for="Product Inclusion">Package Inclusion</label>
                        <select name="product_package_id" class="form-control selected-product_package_id">
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-default add-to-cart-btn">Add to Cart</button>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="code_type">Code Type</label>
                        <select name="code_type_id" class="form-control">
                            @if($_code_type)
                            @foreach($_code_type as $code_type)
                                <option value="{{$code_type->code_type_id}}" {{Request::old('code_type_id') == $code_type->code_type_id ? 'selected' : ''}}>{{$code_type->code_type_name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Recipient">Recipient</label>
                        <select data-placeholder="Select member"  name="account_id" class="form-control chosen-select" placeholder="Select Members">    
                            <option value=""></option>
                            @if($_account)
                            @foreach($_account as $account)
                                <option value="{{$account->account_id}}" {{Request::old('account_id') == $account->account_id ? 'selected' : ''}}>{{$account->account_name}} ({{$account->account_username}})</option>
                            @endforeach
                            @endif()
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Inventory Update">Inventory Update</label>
                        <select name="inventory_update_type_id" class="form-control">
                            @if($_inventory_update_type)
                            @foreach($_inventory_update_type as $inventory_update_type)
                                <option value="{{$inventory_update_type->inventory_update_type_id}}" {{Request::old('inventory_update_type_id') == $inventory_update_type->inventory_update_type_id ? 'selected' : '' }}>{{$inventory_update_type->inventory_update_type_name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
               


        </form> 
    </div>
<div class="remodal loader-container" data-remodal-id="code-modal-qty" data-remodal-options="">
  <button data-remodal-action="close" class="remodal-close modal-btn"></button>
    <form class="form-code-qty">
        <img class="loader" src="/resources/assets/img/floating _arrays.GIF" style="display:none;">
        <div class="form-code-qty-msg">
        </div>
        <div class="form-group">
            <label>Enter Quantity</label>
            <input type="number" name="qty" class="form-control">
            <input type="hidden" name="product_package_id">
        </div>
        <button data-remodal-action="cancel" class="remodal-cancel modal-btn">Cancel</button>
        <button class="remodal-confirm add-to-cart-submit modal-btn">OK</button>
    <form>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/chosen_v1.4.2/chosen.min.css">
    <style type="text/css">
    .loader-container{
        position: relative;
    }

    .loader{
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        z-index: 99;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
          -o-transform: translateY(-50%);
             transform: translateY(-50%);

    }

    .load_opacity{
        opacity: .5;
    }
    </style>
@endsection
@section('script')
    <script type="text/javascript" src="/resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
    <script type="text/javascript">
        

        jQuery(document).ready(function($){

            
            $('.selected-membership-id').on('change', function(event)
            {


                var membership_id = $(this).val();
                var request_product_package_id = $('[name="product_package_id"]').attr('request-product-package-id');

                $.ajax({
                    url: 'admin/maintenance/codes/load-product-package',
                    type: 'get',
                    dataType: 'json',
                    data: {membership_id: membership_id},
                })
                .done(function(data) {

                    var selectedPackageID =  $('.selected-product_package_id');
                    selectedPackageID.empty();
                    if(data.length != 0)
                    {
                        var append = "";
                        var oldRequestPackageId = "{{Request::old('product_package_id')}}";
                        
                        $.each(data, function(index, val)
                        {
                            var selected = oldRequestPackageId == val.product_package_id ? 'selected' : '' ;
                            append  += '<option value="'+ val.product_package_id +'" '+ selected +' >'+ val.product_package_name  +'</option>';

                        });
                        selectedPackageID.append(append);
                    }
                   
                })
                .fail(function() {
                    alert('Something went wrong on loading product package/s.');
                })
                .always(function(){
                });
            });

            $('.selected-membership-id').trigger('change');




        });
    </script>
    <script type="text/javascript">
        $(".chosen-select").chosen({disable_search_threshold: 10});
    </script>
    <script type="text/javascript" src="/resources/assets/admin/code_add.js"></script>
@endsection