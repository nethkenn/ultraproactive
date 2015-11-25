@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Income Breakdown for {{$name == 'Dynamic Compression' ? 'Unilevel Commissions' : $name}} </h2>
    </div>
</div>
    
<div class="form-container">
    @if($name == 'Dynamic Compression')

            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Name (Unilevel Bonus)</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs['dynamic'] as $log)
                    <tr>
                        <td>{!!$log->logs!!}</td>
                        <td>{{number_format($log->wallet_amount,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{number_format($total['dynamic'],2)}}</b></td>
                    </tr>
                </tbody>
            </table>

            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Name (Unilevel Check Match)</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs['checkmatch'] as $log)
                    <tr>
                        <td>{!!$log->logs!!}</td>
                        <td>{{number_format($log->wallet_amount,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{number_format($total['checkmatch'],2)}}</b></td>
                    </tr>
                </tbody>
            </table>

            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Name (Leadership Bonus)</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs['leadership'] as $log)
                    <tr>
                        <td>{!!$log->logs!!}</td>
                        <td>{{number_format($log->wallet_amount,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{number_format($total['leadership'],2)}}</b></td>
                    </tr>
                </tbody>
            </table>

            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Name (Breakaway Bonus)</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs['breakaway'] as $log)
                    <tr>
                        <td>{!!$log->logs!!}</td>
                        <td>{{number_format($log->wallet_amount,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{number_format($total['breakaway'],2)}}</b></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>OVERALL</b></td>
                        <td><b>{{number_format($total['breakaway'] + $total['dynamic'] + $total['leadership'] + $total['checkmatch'],2)}}</b></td>
                    </tr>
                </tbody>
            </table>
    @else
             <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Name</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{!!$log->logs!!}</td>
                        <td>{{number_format($log->wallet_amount,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{number_format($total,2)}}</b></td>
                    </tr>
                </tbody>
            </table>   
    @endif        
</div>

@endsection

@section('script')

@endsection