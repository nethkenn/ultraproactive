@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Check Claims</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='stockist/voucher'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="check-voucher-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-6">
                     <label for="voucher id">Voucher ID</label>
            		<input name="voucher_id" value="{{Request::input('voucher_id')}}" class="form-control" id="" placeholder="" type="text">
            	</div>
                <div class="form-group col-md-6">
                     <label for="voucher id">Voucher Code</label>
                    <input name="voucher_code" value="{{Request::input('voucher_code')}}"  class="form-control" id="" placeholder="" type="text">
                </div>
                <div class="form-group col-md-12">
                     <label for="account password">Enter Password</label>
                @if($_message['account_password'])
                    <div class="form-group col-md-12 alert alert-danger">
                       <ul class = "col-md-12">
                            @foreach ($_message['account_password'] as $message)
                                <li> {{$message}} </li>
                            @endforeach
                        </ul>
                    </div>
                 @endif    
                    <input name="account_password" value="{{Request::input('account_password')}}"  class="form-control" id="" placeholder="" type="password">
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-default">Check Voucher Code</button> 
                </div>
                <div class="form-group col-md-12">
                    @if($_message['voucher_code'] || $_message['voucher_id'])
                        <div class="col-md-12 alert alert-warning">
                            <ul class = "col-md-12">
                                @if($_message['voucher_id'])
                                    @foreach ($_message['voucher_id'] as $message)
                                        <li> {{$message}} </li>
                                    @endforeach
                                @endif
                                @if($_message['voucher_code'])
                                    @foreach ($_message['voucher_code'] as $message)
                                        <li> {{$message}} </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif     
                </div>
        </form>

         @if($voucher)
        <form method="POST" action="/" id="claim-voucher-form">
            <div class="col-md-12 form-group">
                <div class="col-md-4">
                   <h4> <span class="glyphicon glyphicon-ok"></span>
                    Product in voucher</h4>
                </div>
                @if($voucher->status =='unclaimed')
                    <div class="voucher-stat col-md-4 col-md-offset-4 alert alert-success">
                       <strong> This voucher code is still Unclaimed.  </strong>
                    </div>
                 @elseif($voucher->status =='processed')
                    <div class="voucher-stat col-md-4 col-md-offset-4 alert alert-danger ">
                       <strong> This voucher code was already process.</strong>
                    </div>
                @else
                    <div class="voucher-stat col-md-4 col-md-offset-4 alert alert-danger">
                    <strong>    This voucher code is cancelled.</strong>
                    </div>    
                @endif
            </div>
            <div class="col-md-12 form-group">
            <table class="table table-boreded table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Unilevel Pts</th>
                        <th>Binary Pts</th>
                        <th>Qty </th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if($_voucher_product)
                        @foreach ($_voucher_product as $voucher_product)
                            <tr>
                                <td>{{$voucher_product->product_id}}</td>
                                <td>{{$voucher_product->product_name}}</td>
                                <td>{{$voucher_product->price}}</td>
                                <td>{{$voucher_product->unilevel_pts}}</td>
                                <td>{{$voucher_product->binary_pts}}</td>
                                <td>{{$voucher_product->qty}}</td>
                                <td>{{$voucher_product->sub_total}}</td>
                            </tr>
                        @endforeach
                        <tr><td class="text-right" colspan="7">Total : {{$voucher->total_amount}}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="ajax-message" class="col-md-12 form-group">
        </div>
        <div class="col-md-12 form-group">
             <!-- <a type="submit" href="#" class="col-md-offset-4 col-md-4 btn btn-default void-voucher" voucher-id= "{{$voucher->voucher_id}}">Void</a> -->
               <button type="submit" class="col-md-4 btn btn-default submit-claim" voucher-id= "{{$voucher->voucher_id}}">Process Claim</button>
        </div>
        </form>
        @endif
  </div>
@endsection
@section('script')
    <script type="text/javascript" src="resources/assets/admin/stockist_claim.js">
    </script>
@endsection