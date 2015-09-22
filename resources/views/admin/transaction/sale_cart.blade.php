@if($cart)
	@foreach ($cart as $product)
		<tr>
			<td>{{$product['product_id']}}</td>
			<td>{{$product['sku']}}</td>
			<td>{{$product['product_name']}}</td>
			<td>{{$product['price']}}</td>
			<td><a href="" class="edit-qty" product-id="{{$product['product_id']}}">{{$product['qty']}}</a></td>
			<td>{{$product['sub_total']}}</td>
			<td><a href="" class="remove-to-cart" product-id="{{$product['product_id']}}">X</a></td>
			</tr>
	@endforeach
		<tr>
			<td class="text-right" colspan="6">Cart Total :  {{$cart_total}}</td>
		</tr>
		<tr>
			<td class="text-right" colspan="6">Discount : {{$discount}} </td>
		</tr>
		<tr>
			<td class="text-right" colspan="6">Other Charges : {{$other}}% ( {{$other_pts}} )</td>
		</tr>
		<tr>
			<td class="text-right" colspan="6">Final Total :  {{$final_total}}</td>
		</tr>
@endif