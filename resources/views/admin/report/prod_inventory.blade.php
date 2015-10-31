@extends('admin.layout')
@section('content')
<!-- HEADER -->
<input class="token" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Product Inventory Reports</h2>
    </div>
</div>
<div class="form-container">
    <form id="add-product-form" method="post">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
       
        <div class="form-group-container">
         <!--HEADER FILTER -->
        <div class="col-md-8">
          <select name="group-date" class="form-control">
            <option {{ $group == "daily" ? "selected='selected'" : '' }} value ="daily">DAILY</option>
            <option {{ $group == "monthly" ? "selected='selected'" : '' }} value ="monthly">MONTHLY</option>
            <option {{ $group == "yearly" ? "selected='selected'" : '' }} value ="yearly">YEARLY</option>
            <option {{ $group == "all" ? "selected='selected'" : '' }} value ="all">OVERALL</option>
          </select>
        </div>
        <div class="col-md-2 hide">
<!--           <input type="text" placeholder="From" name="from" value="{{ $from }}" class="form-control datepicker"> -->
        </div>
        <div class="col-md-2">
<!--           <input type="text" placeholder="To" name="to" value="{{ $to }}"  class="form-control datepicker"> -->
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary"><i class="fa fa-area-chart"></i> Generate Report</button>
        </div>
      </div>
      <div class="col-md-12" style="margin-top: 30px">
          <table id="data-table" class="table table-bordered data-table">
              <thead>
                  <tr>
                      <th class="option-col">Product ID</th>
                      <th>Product Name</th>
                      <th>Quantity Sold</th>
                  </tr>
              </thead>
              <tbody>
              	@foreach($_inventory as $inventory)
                <tr>
                  <td>{{ $inventory->id }}</td>
                  <td>{{ $inventory->name }}</td>
                  <td>{{ $inventory->value*(-1)}}</td>
                </tr>
                @endforeach
              </tbody>
          </table>
      </div>


      </div>
    </form>
</div>  

@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="resources/assets/jquery-ui/jquery-ui.css">
<script type="text/javascript" src="resources/assets/jquery-ui/jquery-ui.min.js"></script>
<script src="resources/assets/external/highchart.js"></script>
<script src="resources/assets/external/modules/exporting.js"></script>

@endsection