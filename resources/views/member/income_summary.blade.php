@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Income Summary </h2>
    </div>
</div>
    
<div class="form-container">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Name</th>
                        <th class="text-center">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($old_wallet != 0)
                    <tr>
                        <td>Old Wallet</td>
                        <td>{{number_format($old_wallet,2)}} </td>
                        <td><a href="/member/reports/income_breakdown?breakdown_name=Old System Wallet&type=1">Breakdown</a></td>
                    </tr>
                    @endif
                    @if($old_gc != 0)
                    <tr>
                        <td>Old GC </td>
                        <td>{{number_format($old_gc,2)}} </td>
                        <td> <a href="/member/reports/income_breakdown?breakdown_name=Old System GC&type=2">Breakdown</a></td>
                    </tr>
                    @endif
                    <tr>
                        <td>Sponsor GC </td>
                        <td>{{number_format($sponsor_gc,2)}}  </td>
                        <td><a href="/member/reports/income_breakdown?breakdown_name=direct&type=2">Breakdown</a></td>
                    </tr>  
                    <tr>
                        <td>Match Sales GC</td>
                        <td>{{number_format($matching_gc,2)}} </td>
                        <td><a href="/member/reports/income_breakdown?breakdown_name=binary&type=2">Breakdown</a></td>
                    </tr>
                    <tr>
                        <td>Unilevel Commissions </td>
                        <td>{{number_format($dynamic,2)}} </td>
                        <td><a href="/member/reports/income_breakdown?breakdown_name=Dynamic Compression&type=1">Breakdown</a></td>
                    </tr>  
                    <tr>
                        <td>Global Pool Sharing</td>
                        <td>{{number_format($gps,2)}} </td>
                        <td><a href="/member/reports/income_breakdown?breakdown_name=Global Pool Sharing&type=1">Breakdown</a></td>
                    </tr>                           
                    <tr>
                        <td>Sponsor Bonus</td>
                        <td>{{number_format($sponsor,2)}}  </td>
                        <td> <a href="/member/reports/income_breakdown?breakdown_name=direct&type=1">Breakdown</a></td>
                    </tr>
                    <tr>
                        <td>Match Sales Bonus</td>
                        <td>{{number_format($matching,2)}}</td>
                        <td><a href="/member/reports/income_breakdown?breakdown_name=binary&type=1">Breakdown</a></td>
                    </tr>
                    <tr>
                        <td>Mentors Bonus </td>
                        <td>{{number_format($mentor,2)}}</td>
                        <td> <a href="/member/reports/income_breakdown?breakdown_name=matching&type=1">Breakdown</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{number_format($total,2)}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
</div>

@endsection

@section('script')

@endsection