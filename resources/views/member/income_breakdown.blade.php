@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Income Breakdown for {{$name}} </h2>
    </div>
</div>
    
<div class="form-container">
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
</div>

@endsection

@section('script')

@endsection