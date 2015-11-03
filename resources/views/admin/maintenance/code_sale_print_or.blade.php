@extends('admin.layout')
@section('content')
	<div  class="col-md-12">
		<div class="col-12">
			<div class="col-md-6 text-left">
				
				<strong>SALES ORDER</strong>
			</div>
			<div class="col-md-6 text-right">
				{{$codeSale->created_at}}
			</div>
		</div>
		<div class="col-md-12">
			<table class="table">
				<tr>
					<td>Sold to : {{$codeSale->sold_to_name}}</td>
					<td>Order Form Number : {{$codeSale->order_form_number}}</td>
				</tr>
				<tr>
					<td>Payment Type : {{$codeSale->payment_type}}</td>
					<td></td>
				</tr>
			</table>
		</div>

		<div class="col-md-12">
			<table class="table">
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
		<div class="col-md-12 text-right">
			<a class="print-or-btn btn btn-default">Print</a>
		</div>
</div>
@endsection
@section('css')
@endsection
@section('script')
	<script type="text/javascript">
		jQuery(document).ready(function($)
		{

			$('.print-or-btn').on('click', function(event)
			{
				event.preventDefault();
				window.print();
			});

		});
	</script>
@endsection