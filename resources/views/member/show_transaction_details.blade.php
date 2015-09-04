<table class="table table-bordered table-hover table-striped">
    <caption>TRANSACTION DETAILS</caption>
    <thead>
    </thead>
    <body>

        <tr>
            <td>Date / Time</td>
            <td class="text-right">{{$created_at}}</td>
        </tr>
        <tr>
            <td>agentRefNo</td>
            <td class="text-right">{{$agentRefNo}}</td>
        </tr>
        @if($_references)
        @foreach($_references as $ref)
            <tr>
                <td>{{$ref->data_name}}</td>
                <td class="text-right">{{$ref->data_value}}</td>
            </tr>
        @endforeach
        @endif
        <tr>
            <td>Exchange Rate</td>
            <td class="text-right">{{$exchange_rate}}</td>
        </tr>
        <tr>
            <td>Service Charge</td>
            <td class="text-right">{{$service_charge}}</td>
        </tr>
        <tr>
            <td>Amount </td>
            <td class="text-right">{{$amount}}</td>
        </tr>
        <tr>
            <td>Total Amount</td>
            <td class="text-right">{{$total_amount}} ({{$total_amount_in_country}})</td>
        </tr>
        <tr>
            <td>E-wallet Balance Log</td>
            <td class="text-right">{{$e_wallet}}</td>
        </tr>
        <tr>
            <td>E-wallet Less Total Amount Log</td>
            <td class="text-right">{{$e_wallet_less_total}}</td>
        </tr>

    </body>
</table>