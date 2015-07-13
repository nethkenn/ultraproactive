@extends('member.layout')
@section('content')
<div class="cart col-md-5 hidden-lg hidden-md" style="margin-bottom: 25px;">
	<div class="header">
		<img src="/resources/assets/frontend/img/icon-cart.png">
		Shopping Cart
	</div>
	<img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 10px auto">
	<div class="col-md-12 body">
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
                <tr>
                    <td>Sample Product</td>
                    <td>1,500.00</td>
                    <td>10</td>
                    <td>15,030.00</td>
                </tr>
                <tr>
                    <td>Sample Product</td>
                    <td>1,500.00</td>
                    <td>10</td>
                    <td>15,030.00</td>
                </tr>
                <tr>
                    <td>Sample Product</td>
                    <td>1,500.00</td>
                    <td>10</td>
                    <td>15,030.00</td>
                </tr>
            </tbody>
        </table>
        <div class="total">Total&nbsp;&nbsp;:&nbsp;&nbsp;<span>19,820.00</span></div>
        <a href="#checkout">
        	<button type="button">
        		Checkout Now!
        	</button>
        </a>
	</div>
</div>
<div class="encashment product col-md-7">
	<div class="header">
		<img src="/resources/assets/frontend/img/icon-products.png">
		Products
	</div>
	<div class="body">
		<div class="holder para">
			<div class="pix">
				<img src="/resources/assets/frontend/img/boxbox.png">
			</div>
			<div class="text">
				<div class="name">Sample Product</div>
				<div class="price">Php. 1,500.00</div>
				<div class="description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.  </div>
				<div class="boton">
					<a href="javascript:">
						<button>Add to Cart</button>
					</a>
				</div>
			</div>
		</div>
		<div class="holder para">
			<div class="pix">
				<img src="/resources/assets/frontend/img/boxbox.png">
			</div>
			<div class="text">
				<div class="name">Sample Product</div>
				<div class="price">Php. 1,500.00</div>
				<div class="description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.  </div>
				<div class="boton">
					<a href="javascript:">
						<button>Add to Cart</button>
					</a>
				</div>
			</div>
		</div>
		<div class="holder para">
			<div class="pix">
				<img src="/resources/assets/frontend/img/boxbox.png">
			</div>
			<div class="text">
				<div class="name">Sample Product</div>
				<div class="price">Php. 1,500.00</div>
				<div class="description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.  </div>
				<div class="boton">
					<a href="javascript:">
						<button>Add to Cart</button>
					</a>
				</div>
			</div>
		</div>
		<div class="holder para">
			<div class="pix">
				<img src="/resources/assets/frontend/img/boxbox.png">
			</div>
			<div class="text">
				<div class="name">Sample Product</div>
				<div class="price">Php. 1,500.00</div>
				<div class="description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.  </div>
				<div class="boton">
					<a href="javascript:">
						<button>Add to Cart</button>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="cart tsk col-md-5 hidden-sm hidden-xs">
	<div class="header">
		<img src="/resources/assets/frontend/img/icon-cart.png">
		Shopping Cart
	</div>
	<img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 10px auto">
	<div class="col-md-12 body">
		<table>
            <thead class="footable">
                <tr>
                    <th>Product</th>
                    <th data-hide="phone">Price</th>
                    <th data-hide="phone">Quantity</th>
                    <th data-hide="phone">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sample Product</td>
                    <td>1,500.00</td>
                    <td>10</td>
                    <td>15,030.00</td>
                </tr>
                <tr>
                    <td>Sample Product</td>
                    <td>1,500.00</td>
                    <td>10</td>
                    <td>15,030.00</td>
                </tr>
                <tr>
                    <td>Sample Product</td>
                    <td>1,500.00</td>
                    <td>10</td>
                    <td>15,030.00</td>
                </tr>
            </tbody>
        </table>
        <div class="total">Total&nbsp;&nbsp;:&nbsp;&nbsp;<span>19,820.00</span></div>
        <a href="#checkout">
        	<button type="button">
        		Checkout Now!
        	</button>
        </a>
	</div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/product.css">
@endsection
@section('script')
<script type="text/javascript">
	jQuery('.tsk').stickyfloat(
		{
			duration: 400
		});
</script>
@endsection