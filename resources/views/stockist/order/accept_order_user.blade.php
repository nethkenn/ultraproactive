@extends('stockist.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> STOCKIST REQUEST PRODUCT</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	       	 <button onclick="location.href='stockiststockist/accept_stocks/stockist_request'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
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
							</tr>
						</thead>
						<tbody>
							@foreach($product as $prod)
								<tr>
									<td>{{$prod->product_id}}</td>
									<td>{{$prod->product_name}}</td>
									<td>{{$prod->quantity}}</td>
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
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($package as $pack)
								<tr>
									<td>{{$pack->product_package_id}}</td>
									<td>{{$pack->product_package_name}}</td>
									<td>{{$pack->quantity}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
            	</div>
    </div>


    </form>

@endsection













