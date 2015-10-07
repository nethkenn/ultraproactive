<div class="create-slot" style="border: 0;">
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-vouchers.png">
        Vouchers
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="para wew">
        <div class="col-md-6 siyet text-left">
            <img src="/resources/assets/frontend/img/logo.png" style="height: 100px; ">
        </div>
        <div class="col-md-6 siyet text-right">
            <div>{{$account->country_name}}</div>

            <div>{{$account->account_name}}</div>
        </div>
    </div>
    <div class="para epal">
        <div class="title">Ref. No. {{$voucher->voucher_id}}</div>
        <div class="sub para">
            <div class="tudaleft col-md-6 siyet">Code ( {{$voucher->voucher_code}} )</div>
            <div class="tudaright col-md-6 siyet">{{$voucher->created_at}}</div>
        </div>
    </div>
    <div class="para tae">
        <table class="footable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th data-hide="phone">Price</th>
                    <th data-hide="phone">Quantity</th>
                    <th data-hide="phone">Total</th>
                </tr>
            </thead>
            <tbody>
            	@if($_voucher_product)
					@foreach ($_voucher_product as $voucher_product)
						<tr>
							<td>{{$voucher_product->product_name}}</td>
							<td>{{$voucher_product->price}}</td>
							<td>{{$voucher_product->qty}}</td>
							<td>{{number_format($voucher_product->sub_total,2)}}@if(number_format($voucher_product->product_discount,2) != 0)({{number_format($voucher_product->product_discount,2)}}%) @endif</td>
						</tr>
					@endforeach
                    <tr><td class="text-right" colspan="5">Total {{ $prod_sum }}</td></tr>
                    <tr><td class="text-right" colspan="5">Discount {{$discount_decimal}}</td></tr>
                    <tr><td class="text-right" colspan="5">Other Charges {{$voucher->other_charge}} % ({{(($voucher->other_charge/100)*$prod_sum)}})</td></tr>
                    <tr><td class="text-right" colspan="5">Final Total: {{number_format($voucher->total_amount,2)}}</td></tr>
				@else
					<tr><td colspan="5">No products</td></tr>
				@endif
            </tbody>
        </table>
        <div class="potek">
            <a href="javascript:" class="print-voucher-btn">
                <img src="/resources/assets/frontend/img/icon-print.png">
                Print Voucher
            </a>
        </div>
    </div>
</div>
