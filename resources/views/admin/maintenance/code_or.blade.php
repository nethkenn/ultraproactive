@extends('admin.layout')
@section('content')
<div class="header col-md-12" >
    <div class="title col-md-8">
        <h2><i class="fa fa-tag"></i> Generate New Code</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/maintenance/codes'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#code-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Generate</button>
    </div>
</div>
<div class="col-md-12 form-group-container">
    <div id="section-to-print" class="col-md-12">
        <table  class="table table-hover table-bordered" style="width: 100% !important; text-align: center;">
            <caption style="text-align: left;">
                <span style="width: 150px; display: inline-block; font-weight: bold;">Date :</span>{{$membership_code_sale->created_at}} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">Membership</span> Sale OR # {{$membership_code_sale->membershipcode_or_num}} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">OR - CODE :</span> {{$membership_code_sale->membershipcode_or_code}} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">Vocuher #</span> {{$membership_code_sale->voucher_id}} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">Sold To :</span> {{$membership_code_sale->sold_to}} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">Generated By :</span> {{$membership_code_sale->generated_by}} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">Payment :</span> {{$membership_code_sale->payment == 0 ? 'Wallet' : 'Cash' }} <br>
                <span style="width: 150px; display: inline-block; font-weight: bold;">Total Amount :</span> {{number_format ( $membership_code_sale->total_amount, 2 , "." ,  "," )}} <br>
            </caption>
            <thead>
                <tr>
                    <th>Code pin</th>
                    <th>Code</th>
                    <th>Membership</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($_codes as $code)
                <tr>
                    <td>{{$code->code_pin}}</td>
                    <td>{{$code->code_activation}}</td>
                    <td>{{$code->membership_name}}</td>
                    <td>{{number_format ( $code->membership_price, 2 , "." ,  "," )}}</td>
                </tr>
                @endforeach
            </tbody>
            <table class="table table-hover table-bordered">
                <caption>Included Products</caption>
                <thead>
                    <tr>
                        <td>Product ID</td>
                        <td>Product Name</td>
                        <td>Product Qty</td>
                    </tr>
                </thead>
                <tbody>
                    @if($_product)
                    @foreach ($_product as $product)
                    <tr>
                        <td>{{$product->product_id}}</td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->qty}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </table>
    </div>
    <button class="btn btn-primary print-or">Print</button>
    <button class="btn btn-primary post-to-email-btn" or-id="{{$membership_code_sale->membershipcode_or_num}}">
    Send Email
    </button>
</div>
<!--     <form class="post-to-email">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input name="membershipcode_or_num" type="hidden">
</form> -->
<style type="text/css">
    @media print{

        .post-to-email {
            display:  none;
        }

          body * {
            visibility: hidden;
          }
          #section-to-print, #section-to-print * {
            visibility: visible;
          }
          #section-to-print {
            /*position: absolute;
            left: 0;
            top: 0;*/
          }
    }
</style>
@endsection
@section('script')
<script type="text/javascript">
    $('.print-or').on('click', function(event)
    {
        event.preventDefault();
        window.print();
    });


    $('.post-to-email-btn').on('click', function(event)
    {

        var or = $(this).attr('or-id');
        event.preventDefault();
        $.ajax({
            url: 'admin/maintenance/codes/or',
            type: 'post',
            dataType: 'json',
            data: {membershipcode_or_num: or},
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        

    });
</script>
@endsection