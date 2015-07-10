@extends('member.layout')
@section('content')
<div class="encashment voucher code-vault">
    <div class="table">
        <div class="table-head para">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-lead.png">
                Leads ( 5 )
            </div>
            <div class="col-md-6 ew">
                <a href="#generate_lead">
                    <div class="button">How to Generate Leads?</div>
                </a>
                <a href="#add_lead">
                    <div class="button">Add Leads ( Manually )</div>
                </a>
            </div>
        </div>
        <table class="footable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th data-hide="phone">Email</th>
                    <th data-hide="phone">Join Date</th>
                    <th data-hide="phone"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="tibolru">
                    <td>Guillermo Tabligan</td>
                    <td>guillermo129@gmail.com</td>
                    <td>October 17, 1568</td>
                    <td><a href="javascript:">Account Link</a></td>
                </tr>
                <tr class="tibolru">
                    <td>Guillermo Tabligan</td>
                    <td>guillermo129@gmail.com</td>
                    <td>October 17, 1568</td>
                    <td><a href="#javascript:">Account Link</a></td>
                </tr>
                <tr class="tibolru">
                    <td>Guillermo Tabligan</td>
                    <td>guillermo129@gmail.com</td>
                    <td>October 17, 1568</td>
                    <td><a href="#javascript:">Account Link</a></td>
                </tr>
                <tr class="tibolru">
                    <td>Guillermo Tabligan</td>
                    <td>guillermo129@gmail.com</td>
                    <td>October 17, 1568</td>
                    <td><a href="#javascript:">Account Link</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('css')

@endsection