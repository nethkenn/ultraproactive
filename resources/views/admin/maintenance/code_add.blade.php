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
                <div class="form-group col-md-6">
            		<label for="membership">Membership</label>
                    @if($_error['membership_id'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_id'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="membership_id" class="form-control">
                        @if($_membership)
                            @foreach($_membership as $membership)
                                <option value="{{$membership->membership_id}}">{{$membership->membership_name}}</option>
                            @endforeach
                        @endif
                    </select>
            	</div>
                <div class="form-group col-md-6">
                    <label for="code_type">Code Type</label>
                    @if($_error['code_type_id'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['code_type_id'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="code_type_id" class="form-control">
                        @if($_code_type)
                        @foreach($_code_type as $code_type)
                            <option value="{{$code_type->code_type_id}}">{{$code_type->code_type_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="Product Inclusion">Package Inclusion</label>
                    @if($_error['product_package_id'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['product_package_id'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
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
                    @if($_error['account_id'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['account_id'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select data-placeholder="Select member"  name="account_id" class="form-control chosen-select" placeholder="Select Members">    
                        <option value=""></option>
                        @if($_account)
                        @foreach($_account as $account)
                            <option value="{{$account->account_id}}">{{$account->account_name}}</option>
                        @endforeach
                        @endif()
                    </select>
                </div>
                <div class="form-group col-md-12">
                </div>
                                <div class="form-group col-md-6">
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
                                <div class="form-group col-md-6">
                    <label for="Inventory Update">Inventory Update</label>
                    @if($_error['inventory_update_type_id'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['inventory_update_type_id'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="inventory_update_type_id" class="form-control">
                        @if($_inventory_update_type)
                        @foreach($_inventory_update_type as $inventory_update_type)
                            <option value="{{$inventory_update_type->inventory_update_type_id}}">{{$inventory_update_type->inventory_update_type_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>      
        </form>
    </div>
@endsection
@section('script')
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
                    url: 'admin/maintenance/codes/load-product-package',
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