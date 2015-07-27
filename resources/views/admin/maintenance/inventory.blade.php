@extends('admin.layout')
@section('content')
<!-- HEADER -->


<div class="header">
    <div class="title col-md-8">
        <h2><i class="fa fa-check-square-o"></i>Inventory</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <!-- <button type="button" onclick="location.href='admin/inventory?export=csv'" class="btn btn-default"><i class="fa fa-external-link-square"></i> EXPORT</button> -->
        <button  type="button" class="bulk btn btn-primary"><i class="fa fa-plus"></i> BULK REFILL</button>
    </div>
</div>


<!-- INVENTORY -->
<div class="col-md-12">
        @if($_inventory)
    <table id="data-table" class="table table-bordered data-table">
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="allcheck"></input></th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Stocks</th>
                <th class="text-center">Adjust</th>
            </tr>
        </thead>
        <tbody>
            @foreach($_inventory as $inventory)
            <tr class="bulked">
                <td id="test" style="text-align:center;"><input class="checkbox1" type="checkbox" ids="{{$inventory->product_id}}" amount="{{$inventory->stock_qty}}" ingname="{{$inventory->product_name}}"></td>
                <td class="text-center">{{ $inventory->product_name }}</td>
                <td class="text-center">{{ $inventory->stock_qty }}</td>
                <td class="text-center"><a href="javascript:" class="adjustlink" ids="{{$inventory->product_id}}" amount="{{$inventory->stock_qty}}">Adjust</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="text-center">No records</p>
    @endif
</div>


<!-- Modal for bulk -->
<div class="remodal" data-remodal-id="bulk" data-remodal-options="hashTracking: false">
<form id="add-product-form" method="post" action="admin/maintenance/inventory">
   <input class="token" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
  <div class="amount">
           <div class="col-md-12">
                <table id="order-table" class="table table-bordered data-table">    
                  <thead>
                     <tr>
                        <th class="text-center">Ingredient Name</th>
                        <th class="text-center">Remaning Amount</th>
                        <th class="text-center">Replenish Stocks</th>
                     </tr>
                  </thead>
                  <tbody class='bulkcontainers'>
                    <!-- Container -->
                  </tbody> 
               </table>
                <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
                </br>
                           <button type="submit" name="addfood"class="btn btn-primary">Save</button>
            </div>
  </div>
</form>
</div>




<!-- Adjust Remodal  -->
<div class="remodal" data-remodal-id="single" data-remodal-options="hashTracking: false">
<form id="add-product-form" method="post">
       <input class="token" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
       <div class="kontainer">
       </div>
          <div class="col-md-12">
            <div style="width:275px; margin:auto; text-align:left;">
              <div class="form-group">
                <label for="one" style="width:70px;">Action:</label>
                <select name="option" id="one"> 
                  <option value="1">Consume Stocks</option>
                  <option value="2">Change the Stocks</option>
                  <option value="3">Add Stocks</option>
                </select>
              </div>
              <div class="form-group">
                <label for="two" style="width:70px;">Amount:</label> 
                <input id="two" type="number" name="singleamount" id="singlename">
              </div>
            </div>
        </div>


      <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
      <button type="submit" name="singleadd"class="btn btn-primary">Save</button>

</form>
</div>





@endsection

@section('script')
<script type="text/javascript" src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript" src="resources/assets/fbox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="resources/assets/fbox/jquery.fancybox.css?v=2.1.5" media="screen"/>
<script type="text/javascript" src="resources/assets/admin/inventory.js"></script>
@endsection



