@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Encashment History </h2>
    </div>
</div>
    
<div class="form-container">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Amount</th>
                        <th class="text-center">Status</th>   
                        <th class="text-center">Date Encashed</th>   
                        <th class="text-center">Type</th>    
                    </tr>
                </thead>
                <tbody>
                    @foreach($_encash as $encash)
                        <tr>
                            <td>{{number_format($encash->amount,2)}}</td>
                            <td>{{$encash->status}}</td>
                            <td>{{date("F d, Y - h:i A", strtotime($encash->encashment_date))}}</td>
                            <td>{{$encash->type}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>

@endsection

@section('script')

@endsection