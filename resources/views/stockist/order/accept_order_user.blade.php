@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> STOCKIST REQUEST PRODUCT</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	       	 <button onclick="location.href='stockist/accept_stocks'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#product-package-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> TRANSFER</button>
	    </div>
    </div>
    @if($error)
    <div class="col-md-12 alert alert-danger form-errors">
        <ul>
            @foreach($error as $errors)
                <li>{{$errors}}</li>
            @endforeach
        </ul>
    </div>
	@endif
    <form id="product-package-add-form" method="post">
    <div class="col-md-12 form-group-container">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
               	<div class="title col-md-8">
			        <h2> PRODUCT ORDER </h2>
			    </div>
            	<div class="form-group col-md-12">
				    <table id="product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Discount</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($product as $prods)
								<tr>
									<td>{{$prods->product_id}}</td>
									<td>{{$prods->product_name}}</td>
									<td>{{$prods->quantity}}</td>
									<td>{{$prods->price}}</td>
									<td>{{$prod}}%</td>
									<td>{{$prods->price - (($prod/100)*$prods->price)}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
				<div class="title col-md-8">
			        <h2> PACKAGE ORDER </h2>
			    </div>
            	<div class="form-group col-md-12">
            		<table id="added-product-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Discount</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($package as $packs)
								<tr>
									<td>{{$packs->product_package_id}}</td>
									<td>{{$packs->product_package_name}}</td>
									<td>{{$packs->quantity}}</td>
									<td>{{$packs->price}}</td>
									<td>{{$pack}}%</td>
									<td>{{$packs->total}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
            	</div>
    </div>


    </form>

@endsection













