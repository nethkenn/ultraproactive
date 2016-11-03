<form id="checkout-form" class="form-horizontal">
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
                    <input type="text" class="form-control" id="a1" value="{{number_format($current_wallet,2)}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a2" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a2" value="{{number_format($final_total,2)}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a3" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a3" value="{{number_format($remaining_bal,2)}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a2" class="col-sm-3 control-label">Total Amount For GC</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a2" value="{{number_format($final_total_for_gc,2)}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a3" class="col-sm-3 control-label">Remaining GC after use</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a3" value="{{number_format($remaining_bal_gc,2)}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a4" class="col-sm-3 control-label">Total UPCoins(Not for GC)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a4" value="{{$pts['unilevel']}}" readonly>
                </div>
            </div>
            <div class="form-group para">
                <label for="a5" class="col-sm-3 control-label">Total Binary Points (Not for GC)</label>
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
    <button id="cancel-checkout" class="button">Cancel</button>
    <button type="submit" class="checkawt button {{$customer_stats->disable_product == 1 ? 'hidden' : ''}}" id="submit-checkout">Submit Checkout</button>
    <button type="submit" class="checkawt button {{$customer_stats->disable_product == 1 ? 'hidden' : ''}}" id="submit-checkout-gc">Submit Checkout Using GC</button>
</form>



