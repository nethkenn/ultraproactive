<form id="checkout-form" class="form-horizontal">
  {{--  <div class="form-group">
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
  </div> --}}

    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-checkout.png">
        Checkout
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
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="a1" class="col-sm-3 control-label">Wallet</label>
                <div class="col-sm-9">
                    <input type="text" value="Slot #8" class="form-control" id="a1" value="{{$slot->slot_wallet}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a2" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a2" value="{{$final_total}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a3" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a3" value="{{$remaining_bal}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a4" class="col-sm-3 control-label">Total Unilevel Points</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a4" value="{{$pts['unilevel']}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a5" class="col-sm-3 control-label">Total Binary Points</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a5" value="{{$pts['binary']}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a6" class="col-sm-3 control-label">Points Recipient</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a6" value="Slot {{$slot->slot_id}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a6" class="col-sm-3 control-label">Membership Discount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a6" value="{{$slot->discount}}" readonly>
                </div>
            </div>
        </form>
    </div>
    <br>
    <button class="checkawt button" data-remodal-action="confirm">Submit Checkout</button>
</form>



