@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Generate New Code</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='stockist/membership_code'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#code-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Generate</button>
	    </div>
    </div>

    <div class="col-md-12 form-group-container">
        <form id="code-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-6">
            		<label for="membership">Membership</label>
                    @if($errors->get('membership_id'))
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->get('membership_id') as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="membership_id" class="form-control">
                        @if($_membership)
                            @foreach($_membership as $membership)
                                <option value="{{$membership->membership_id}}" {{Request::old('membership_id') == $membership->membership_id ? 'selected' : ''}}>{{$membership->membership_name}}</option>
                            @endforeach
                        @endif
                    </select>
            	</div>
                <div class="form-group col-md-6">
                    <label for="code_type">Code Type</label>
                    @if($errors->get('code_type_id'))
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->get('code_type_id') as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="code_type_id" class="form-control">
                        @if($_code_type)
                        @foreach($_code_type as $code_type)
                            <option value="{{$code_type->code_type_id}}" {{Request::old('code_type_id') == $code_type->code_type_id ? 'selected' : ''}}>{{$code_type->code_type_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="Product Inclusion">Package Inclusion</label>
                    @if($errors->get('product_package_id'))
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->get('product_package_id') as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ $_error2 }}</li>
                            </ul>
                        </div>
                    @endif
                    <select name="product_package_id" class="form-control select-product_package" request-product-package-id = {{Request::old('product_package_id')}}>
                        <option value="">Select Product Package</option>
<!--                          @if($_prod_package)
                        @foreach($_prod_package as $prod_package)
                            <option value="{{$prod_package->product_package_id}}">{{$prod_package->product_package_name}}</option>
                        @endforeach
                        @endif -->
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="Recipient">Recipient</label>
                    @if($errors->get('account_id'))
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->get('account_id') as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select data-placeholder="Select member"  name="account_id" class="form-control chosen-select" placeholder="Select Members">    
                        <option value="">Select Account</option>
                        @if($_account)
                        @foreach($_account as $account)
                            <option value="{{$account->account_id}}" {{Request::old('account_id') == $account->account_id ? 'selected' : ''}}>{{$account->account_name}}</option>
                        @endforeach
                        @endif()
                    </select>
                </div>
                <div class="form-group col-md-12">
                </div>
                <div class="form-group col-md-6 hide">
                    <label for="Recipient">Code multiplier</label>
                    @if($_error['code_multiplier'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['code_multiplier'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input class="form-control" type="number" value="1" name="code_multiplier"/>
                </div>  

                <div class="form-group col-md-6 hide">
                    <label for="Inventory Update">Inventory Update</label>
                    @if($errors->get('inventory_update_type_id'))
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->get('inventory_update_type_id') as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="inventory_update_type_id" class="form-control">
                        @if($_inventory_update_type)
                        @foreach($_inventory_update_type as $inventory_update_type)
                            <option value="{{$inventory_update_type->inventory_update_type_id}}" {{Request::old('inventory_update_type_id') == $inventory_update_type->inventory_update_type_id ? 'selected' : '' }}>{{$inventory_update_type->inventory_update_type_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>    
                <div class="form-group col-md-6">
                    <label for="Inventory Update">Order Form Number</label>
                    @if($errors->get('order_form_number'))
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($errors->get('order_form_number') as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input name="order_form_number" class="form-control" type="text">
                </div>      
        </form>
    </div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/chosen_v1.4.2/chosen.min.css">
@endsection
@section('script')
    <script type="text/javascript" src="resources/assets/admin/process_stockist_sale.js"></script>
      <script type="text/javascript" src="/resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
      <script type="text/javascript">
      $(".chosen-select").chosen({disable_search_threshold: 10});
    </script>
    <script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
    <script type="text/javascript">
        

        $(document).ready(function()
        {

            
            $('[name="membership_id"]').on('change', function(event)
            {


                var membership_id = $(this).val();
                var request_product_package_id = $('[name="product_package_id"]').attr('request-product-package-id');

                $.ajax({
                    url: 'stockist/membership_code/load-product-package',
                    type: 'get',
                    dataType: 'json',
                    data: {membership_id: membership_id},
                })
                .done(function(data) {
       
                    $('[name="product_package_id"] option:not([value=""])').remove();



                    if(data.length != 0)
                    {
                        $.each(data, function(index, val)
                        {
                            var check = request_product_package_id == val['product_package_id'] ? 'selected' : '';

                            $('[name="product_package_id"]').append('<option value="'+val['product_package_id']+'" '+check+'>'+val['product_package_name']+'</option>')
                            
                        });
                    }
                    else
                    {
                         $('[name="product_package_id"]').append("<option>No product package</option>");
                    }
                   
                })
                .fail(function() {
                    // console.log("error");
                    alert('Something went wrong on loading product package/s.');
                })
                .always(function() {
                    // console.log("complete");
                });
            });

             $('[name="membership_id"]').trigger('change');


                



        });
    </script>
@endsection