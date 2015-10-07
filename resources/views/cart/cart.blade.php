        @if($_cart)
            @foreach ($_cart as $key => $product)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$product['product_name']}}</td>
                    <td>{{$product['price']}}</td>
                    <td>{{$product['qty']}}</td>
                    <td>{{number_format($product['total'],2)}}@if($product['discount'] != 0)({{number_format($product['discount'],2)}}%)@endif</td>
                    <td><a class="remove-to-cart" product-id="{{$key}}" href="#">X</a></td>
                </tr>
            @endforeach
            <tr><td class="text-right" colspan="6"> Total {{$sum_product}} </td></tr>
             <tr><td class="text-right" colspan="6">Discount {{$discount}} </td></tr>

           <tr><td class="text-right" colspan="6">Final Total: {{$final_total}}</td></tr>
        @else
            <tr ><td colspan="6" class="text-center" >Cart Empty</td></tr>
        @endif