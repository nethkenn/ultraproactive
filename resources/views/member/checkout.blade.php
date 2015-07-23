<form id="checkout-form" class="form-horizontal">
   <div class="form-group">
     <h2>Checkout</h2>
   </div>
       @if($_error)
      <div class="text-left col-md-12 alert alert-danger">
        <ul class="col-md-12">
          @foreach ($_error as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
    @endif
  <div class="form-group">
    <label for="slot wallet" class="col-sm-4 control-label">Wallet</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="slot_wallet" value="{{$slot->slot_wallet}}">
    </div>
  </div>
  <div class="form-group">
    <label for="total amount" class="col-sm-4 control-label">Total Amount</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="final_amount" value="{{$final_total}}">
    </div>
  </div>
    <div class="form-group">
    <label for="remaining balance" class="col-sm-4 control-label">Remaining</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="remaining_bal" value="{{$remaining_bal}}">
    </div>
  </div>
  <div class="form-group">
    <label for="total unilevel points" class="col-sm-4 control-label">Total Unilevel Points</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="total_unilevel_pts" value="{{$pts['unilevel']}}">
    </div>
  </div>
    <div class="form-group">
    <label for="total binary points" class="col-sm-4 control-label">Total Binary Points</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="total_binary_pts" value="{{$pts['binary']}}">
    </div>
  </div>
   <div class="form-group">
    <label for="points recipient" class="col-sm-4 control-label">Slot #</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="points_recipient" value="{{$slot->slot_id}}">
    </div>
  </div>

  <div class="form-group">
    <label for="points recipient" class="col-sm-4 control-label">Slot Membership Discount(%)</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" id="" placeholder="" name="points_recipient" value="{{$slot->discount}}">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <button id="cancel-checkout" class="btn btn-default">Cancel</button>
      <button type="submit" class="btn btn-default" id="submit-checkout">Checkout</button>
    </div>
  </div>
</form>



