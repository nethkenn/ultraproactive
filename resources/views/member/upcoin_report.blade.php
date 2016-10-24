@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> UPcoin Summary </h2>
    </div>
</div>
    
<div class="form-container">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Details</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($_logs as $logs)
                    <tr>
                        <td>{{$logs->detail}} </td>
                        <td>{{number_format($logs->amount,2)}}</td>
                        <td>{{$logs->date_created}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>          
                    </tr>
                    <tr>
                        <td><b>Subtotal</b></td>
                        <td></td>          
                        <td><b>{{number_format($subtotal,2)}}</b></td>
                    </tr>
                    <tr>
                        <td><b>Total Redeemed</b></td>
                        <td></td>   
                        <td><b>{{number_format($redeem,2)}}</b></td>
                    </tr>
                    <tr>
                        <td><b>Total</b></td>
                        <td></td>
                        <td><b>{{number_format($total,2)}}</b></td>
                    </tr>
                </tbody>
            </table>
</div>

@endsection

@section('script')

@endsection