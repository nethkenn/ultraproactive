@extends('admin.layout')
@section('content')
  <div class="header col-md-12" >
      <div class="title col-md-8">
          <h2><i class="fa fa-tag"></i> REFILL LOGS VIEW</h2>
      </div>
      <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/reports/refill_logs'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
      </div>
     <div class="pricenopack text-right"><h3>Total Price: {{$transaction->transaction_total_amount}}</h3></div>
@if($checking == 1)
    @if($product->count() != 0)
    <div class="col-md-12 form-group-container">
              <div class="form-group col-md-12">
            <table id="product-table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($product as $prod)
              <tr>
                <td>{{$prod->product_id}}</td>
                <td>{{$prod->product_name}}</td>
                <td>{{$prod->transaction_qty}}</td>
                @if($prod->product_discount != 0 && $prod->transaction_amount == ($prod->transaction_total / $prod->transaction_qty))
                  <td>{{$prod->transaction_amount + ($prod->product_discount_amount/$prod->transaction_qty)}}</td>
                  <td>{{$prod->product_discount}}%</td>
                  <td>{{$prod->transaction_total}}</td>
                @else
                  <td>{{$prod->transaction_amount}}</td>
                  <td>{{$prod->product_discount}}%</td>
                  <td>{{$prod->transaction_total}}</td>
                @endif
              </tr>
              @endforeach
            </tbody>
           </table>     
    </div>
    </div>
    @endif
    @if($package->count() != 0)
         <div class="form-group-container col-md-12">
            <table id="product-table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Product Package Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($package as $prod)
              <tr>
                <td>{{$prod->product_package_id}}</td>
                <td>{{$prod->product_package_name}}</td>
                <td>{{$prod->transaction_qty}}</td>
                @if($prod->product_discount != 0 && $prod->transaction_amount == ($prod->transaction_total / $prod->transaction_qty))
                  <td>{{$prod->transaction_amount + ($prod->product_discount_amount/$prod->transaction_qty)}}</td>
                  <td>{{$prod->product_discount}}%</td>
                  <td>{{$prod->transaction_total}}</td>
                @else
                  <td>{{$prod->transaction_amount}}</td>
                  <td>{{$prod->product_discount}}%</td>
                  <td>{{$prod->transaction_total}}</td>
                @endif
              </tr>
              @endforeach
            </tbody>
           </table> 
           <div class="pricenopack text-right">Total Price: {{$transaction->transaction_total_amount}}</div>
        </div>
    @Endif
@endif

@if($checking == 2)
    <div class="col-md-12 form-group-container">
              <div class="form-group col-md-12">
            <table id="product-table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Code Pin</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($code as $c)
              <tr>
                <td>{{$c->code_pin}}</td>
                <td>{{$c->transaction_total}}</td>
              </tr>
              @endforeach
            </tbody>
           </table>     
    </div>
    </div>
@endif





@endsection














