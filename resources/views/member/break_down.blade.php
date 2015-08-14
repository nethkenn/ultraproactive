<table class="table table-bordered table-hover table-striped">
    <caption>TRANSACTION BREAKDOWN</caption>
    <thead>
    </thead>
    <body>
        <tr>
            <td>Exchange Rate</td>
            <td class="text-right">{{$exchange_rate_formatted}}</td>
        </tr>
        <tr>
            <td>Service Charge</td>
            <td class="text-right">{{$service_charge_formatted}}</td>
        </tr>
        <tr>
            <td>Amount </td>
            <td class="text-right">{{$amount_formatted}}</td>
        </tr>

        <tr>
            <td>Total Amount</td>
            <td class="text-right">{{$total_amount_formatted}} ({{$total_amount_in_country_formatted}})</td>
        </tr>
        <tr>
            <td>Current E-wallet Balance </td>
            <td class="text-right">{{$current_wallet_formatted}}</td>
        </tr>
        <tr>
            <td>E-wallet Less Total Amount</td>
            <td class="text-right">{{$current_wallet_less_total_formatted}}</td>
        </tr>

    </body>
</table>