@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-12">
        <h2><i class="fa fa-table"></i> UPcoin Summary </h2>
    </div>
</div>
    
<div class="form-container">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">January</th>
                        <th class="text-center">February</th>
                        <th class="text-center">March</th>
                        <th class="text-center">April</th>
                        <th class="text-center">May</th>
                        <th class="text-center">June</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>UPcoin:{{$january}}</td>
                        <td>UPcoin:{{$february}}</td>
                        <td>UPcoin:{{$march}}</td>                           
                        <td>UPcoin:{{$april}}</td>
                        <td>UPcoin:{{$may}}</td>
                        <td>UPcoin:{{$june}}</td>          
                    </tr>                   
                    <tr>
                        <td><b>July</b></td>
                        <td><b>August</b></td>
                        <td><b>September</b></td>                           
                        <td><b>October</b></td>
                        <td><b>November</b></td>
                        <td><b>December</b></td>          
                    </tr>   
                    <tr>
                        <td>UPcoin:{{$july}}</td>
                        <td>UPcoin:{{$august}}</td>
                        <td>UPcoin:{{$september}}</td>                           
                        <td>UPcoin:{{$october}}</td>
                        <td>UPcoin:{{$november}}</td>
                        <td>UPcoin:{{$december}}</td>          
                    </tr>
                    <tr>
                        <td colspan="2" class="text-left">Total Personal UPcoin:{{$subtotal}}</td>
                        <td colspan="2" class="text-left">Total Group UPcoin:{{$gpv}}</td>                           
                        <td colspan="2" class="text-left">Max Match:{{$match}}</td>
                    </tr>
                </tbody>
            </table>
</div>

@endsection

@section('script')

@endsection