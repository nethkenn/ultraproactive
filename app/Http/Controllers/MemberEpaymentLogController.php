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
use App\Tbl_slot;
use Session;
use Validator;
use App\Classes\Log;
use App\Tbl_account;


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

    public function slot_wallet_to_currency()
    {

        $data = $this->convert_pt_to_currency(Request::input('amount'));


    	return view('member.epayment_log_convert_currency', $data);
    }


    public function convert_pt_to_currency($amount)
    {
        $amount = (double) $amount;
        $country = Tbl_country::find(Customer::info()->account_country_id);
        $slot = Tbl_slot::find(Session::get('currentslot'));
        $rate = $country->rate;
        $slot_wallet = $slot->slot_wallet - $amount;
        $converted_amount = $amount * $country->rate;
        $e_wallet = Customer::info()->e_wallet + $converted_amount ;
        $data['rate_formatted'] = "1.00 slot wallet points = " . number_format($rate,2,".",","). ' '.$country->currency;
        $data['slot_wallet_formatted'] = number_format($slot_wallet,2,".",",");
        $data['amount_formatted'] =  number_format($amount,2,".",",") . ' ('.number_format($converted_amount,2,".",",").' '.$country->currency.')' ;
        $data['e_wallet_formatted'] =  number_format($e_wallet,2,".",",") . ' ' . $country->currency;
        
        $data['rate'] = $rate;
        $data['slot_wallet'] = $slot_wallet;
        $data['converted_amount'] = $converted_amount;
        $data['currency'] = $country->currency;
        $data['amount'] = $amount;
        $data['slot'] = $slot;

        return $data;
    }

    public function convert_slot_to_ewallet()
    {

        $amount = (double) Request::input('amount');
        $conversion = $this->convert_pt_to_currency($amount);

        $requests['amount'] = $amount;
        $rules['amount'] = 'required|numeric|min:1';

        $requests['slot_wallet'] = $conversion['slot_wallet'];
        $rules['slot_wallet'] = 'required|numeric|min:0';
        
        $requests['slot'] = Session::get('currentslot');
        $rules['slot'] = 'exists:tbl_slot,slot_id,slot_owner,'.Customer::info()->account_id;

        $validator = Validator::make($requests, $rules);
        // dd($amount, $conversion, $validator->errors()->all());
        if ($validator->fails())
        {
            return redirect('member/e-payment/transaction-log')
                        ->withErrors($validator)
                        ->withInput();
        }


        $slot = Tbl_slot::find(Session::get('currentslot'));
        $slot->slot_wallet = $slot->slot_wallet - $amount;
        $slot->save();


        $slog_log = 'Converted '.$amount.' slot wallet  to '. $conversion['converted_amount'] . ' ' . $conversion['currency']. ' by '.Customer::info()->account_name . ' ( ' .Customer::info()->account_username .' ). ';
        Log::slot($slot->slot_id, $slog_log, $slot->slot_wallet);

        $account = Tbl_account::find(Customer::info()->account_id);
        $account->e_wallet = $account->e_wallet + $conversion['converted_amount'];
        $account->save();

        $e_wallet_log = 'Loaded '. $conversion['converted_amount'] . ' ' . $conversion['currency']. ' from slot # '. $slot->slot_id . ' by '.Customer::info()->account_name . ' ( ' .Customer::info()->account_username .' ). ';
        Log::e_wallet($account->account_id, $e_wallet_log, $account->e_wallet);


        return redirect()->back()->with('message', "E-wallet updated to ". number_format($account->e_wallet,2,".",",") .' '. $conversion['currency']);
        
    }






}