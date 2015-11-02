@if(count($cart) > 0 )
	@foreach($cart as $key => $val)
		<tr>
		    <td>{{$val['membership_id']}}</td>
		    <td>{{$val['membership_name']}}</td>
		    <td>{{$val['product_package_id']}}</td>
		    <td>{{$val['product_package_name']}}</td>
		    <td>{{$val['qty']}}</td>
		    <td>{{$val['membership_price']}}</td>
		    <td>{{$val['sub_total']}}</td>
		    <td  ><i class="glyphicon glyphicon-remove remove-from-cart" cart-index="{{$key}}" style="cursor:pointer"></i></td>
		</tr>
	@endforeach
	<tr>
		<td class="text-right" colspan="7s"><strong>Total : {{$finalTotal}}</strong></td>
		<td></td>
	</tr>
@else
	<tr>
		<td colspan="8"><strong> Cart empty</strong></td>
	</tr>
@endif