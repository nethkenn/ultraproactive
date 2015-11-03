<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title></title>
	</head>
	<body>
		<style type="text/css">
/*	table {
  		border-spacing: 0.5rem;
  		width: 100%;
	}*/

/*	table {
  		border-collapse: collapse;
	}
*/
	td {
		border:1px solid black;
		padding: 5px;
	}

	table tr td
	{
		border: none;
	}


	table
	{
		width: 100%;
		border-spacing: 0.5rem;
	}

	.text-right{
		text-align: right;
	}

		.text-left{
		text-align: left;
	}

	table.codes{
		border-collapse: collapse;
	}
	
	table.codes tr td
	{
		border: 1px solid black;
	}





</style>
		<div class="col-12">
{{-- 			<div class="col-md-6 text-left">
				
				<strong>SALES ORDER</strong>
			</div>
			<div class="col-md-6 text-right">
				{{$codeSale->created_at}}
			</div> --}}
			<table class="or_title">
				<tr>
					<td><strong>SALES ORDER</strong></td>
					<td class="text-right">{{$codeSale->created_at}}</td>
				</tr>
			</table>

		</div>
		<div class="col-md-12">
			<div class="col-md-12">
				<table class="table">
					<tr>
						<td>Sold to : {{$codeSale->sold_to_name}}</td>
						<td class="text-right">Order Form Number : {{$codeSale->order_form_number}}</td>
					</tr>
					<tr>
						<td>Payment Type : {{$codeSale->payment_type}}</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div>
				<table class="codes">
			<thead>
				<tr>
					<th>Code Pin</th>
					<th>Code Activation</th>
					<th>Membership - Product Package</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Sub Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach($codes as $code)
					<tr>
						<td>{{$code->code_pin}}</td>
						<td>{{$code->code_activation}}</td>
						<td>{{$code->membership_name}} - {{$code->product_package_name}}</td>
						<td>{{$code->sold_price}}</td>
						<td>1</td>
						<td>{{$code->sold_price}}</td>
					</tr>
				@endforeach
				<tr>
					<td class="text-right" colspan="6"><strong>Final Total : {{number_format($codeSale->total_amount,2)}} PHP</strong></td>
				</tr>
				<tr>
					<td class="text-right" colspan="6"><strong>Payment : {{number_format($codeSale->tendered_payment,2)}} PHP</strong></td>
				</tr>
				<tr>
					<td class="text-right" colspan="6"><strong>Change : {{number_format($codeSale->change, 2)}} PHP</strong></td>
				</tr>
			</tbody>
		</table>
		</div>
	</body>
</html>