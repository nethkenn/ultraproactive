<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_epayment_transaction;
use Datatables;
use App\Classes\Customer;
use App\Tbl_response_data;
use App\Tbl_country;

class MemberEpaymentLogController extends MemberController
{

    public function index()
    {

        $e_wallet = Customer::info()->e_wallet;

        $currency = Tbl_country::find(Customer::info()->account_country_id)->currency;

        $data['e_wallet'] = number_format($e_wallet, '2','.',',') .' '.$currency;
        return view("member.epayment_log", $data);
    }

    public function get_data()
    {

        $transaction = Tbl_epayment_transaction::transaction()->where('account', Customer::info()->account_id)->orderBy('created_at', 'desc');

        return Datatables::of($transaction)  
                                                ->editColumn('created_at', '{{$created_at->format("M j, Y")}}')
                                                ->addColumn('view_details','<a style="cursor: pointer;" class="view-details" agentRefNo="{{$agentRefNo}}">VIEW DETAILS</a>')
                                                ->make(true);
    }

    public function show_details()
    {
        $agentRefNo = Request::input('agentRefNo');
        $account_id = Customer::info()->account_id;
        $php = " PHP";
        $transaction = Tbl_epayment_transaction::transaction()->currency()->where('account', $account_id)->where('agentRefNo', $agentRefNo)->first();
       
        if(!$transaction)
        {
            return "TRANSACTION NOT FOUND.";
        }

        $data['exchange_rate'] = "1.00 ".$transaction->currency. " = ".  number_format($transaction->rate_peso,2,".",",") .' PHP';
        $data['created_at'] = $transaction->created_at->toDayDateTimeString();
        $data['service_charge'] = number_format($transaction->service_charge,2,".",","). $php;
        $data['amount'] = number_format($transaction->amount,2,".",","). $php;
        $data['total_amount'] = number_format($transaction->total_amount,2,".",","). $php;
        $data['total_amount_in_country'] = number_format($transaction->total_amount_in_country,2,".",","). ' '.$transaction->currency;
        $data['e_wallet'] = number_format($transaction->e_wallet,2,".",","). ' '.$transaction->currency;
        $data['e_wallet_less_total'] = number_format($transaction->e_wallet_less_total,2,".",","). ' '.$transaction->currency;
        $data['_references'] = Tbl_response_data::where('agentRefNo', $agentRefNo)->get();
        $data['agentRefNo'] = $agentRefNo;


        

        
        return view('member.show_transaction_details', $data);



    }

    public function test()
    {
    	
    }






}
