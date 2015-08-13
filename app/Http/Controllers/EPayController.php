<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\EPayment;
use Request;
use App\Tbl_epayment_transation_code_list;
use App\Classes\Customer;
use App\Tbl_service_charge;
use App\Tbl_exchange_rate;


class EPayController extends MemberController
{

 

    public function index()
    {
       
        $data['_input_field'] = null;
        if(Request::isMethod('get') && Request::input('transaction_code'))
        {

            $data['_input_field'] = EPayment::get_field(Request::input('transaction_code'));

        }

        $data['service_chage'] = Tbl_service_charge::where('service_charge_id', 1)->first()->value;
        $data['_request_code'] = Tbl_epayment_transation_code_list::getFront()->get();
        return view('member.epayment', $data);
    }

    public function process()
    {


        // Customer::info()->
        $validate = EPayment::validate_field(Request::input('transaction_code'),Request::input('param'));

        // dd($validate);
        $transaction_code = Request::input('transaction_code');
        if($validate['responseCode'] != 100)
        {
            $error = 'Response code #'.$validate['responseCode']. ' : '.$validate['remarks'];
            return redirect()->back()->withInput()->with('error', $error);
        }

        $e_wallet =  Customer::info()->e_wallet;
        $customer_country_id = Customer::info()->account_country_id;
        $conversion_rate = Tbl_exchange_rate::where('country_id', $customer_country_id)->first();
        $e_wallet = 



      


         dd($validate,Customer::info(),$customer_country_id,$conversion_rate);





        
        

        // $transaction = EPayment::signIn('Process', $transaction_code, Request::input());
        // dd(Request::input(), $transaction);
        // return $transaction;


        

    }


    public function compute_transaction($amount)
    {
        $e_wallet =  Customer::info()->e_wallet;
        $customer_country_id = Customer::info()->account_country_id;
        $conversion_rate = Tbl_exchange_rate::GetCurrency()->where('tbl_exchange_rate.country_id', $customer_country_id)->first();
        
        $data['exchange_rate'] = $conversion_rate->peso_rate;
        $data['exchange_rate_formatted'] = "1.00 ".$conversion_rate->currency. " = ".  number_format($conversion_rate->peso_rate,2,".",",") .' PHP';

        $data['service_charge'] = Tbl_service_charge::where('service_charge_id', 1)->first()->value;
        $data['service_charge_formatted'] = number_format($data['service_charge'], 2,".",",") . " PHP";

        $data['amount'] = (double) $amount ;
        $data['amount_formatted'] = number_format($data['amount'] , 2,".",",") . " PHP";

        if($data['amount'] <= 0)
        {
            $data['total_amount'] = $data['total_amount_in_country'] = $data['current_wallet'] = $data['current_wallet_less_total'] = 0;
        }
        else
        {
            $data['total_amount'] = $data['service_charge'] + $data['amount'];
            $data['total_amount_in_country'] = $data['total_amount'] / $data['exchange_rate'];
            $data['current_wallet'] = $e_wallet;
            $data['current_wallet_less_total'] = $data['current_wallet'] - $data['total_amount_in_country'];
        }
    
        $data['total_amount_formatted'] = number_format($data['total_amount'],2,".",","). " PHP";
        $data['total_amount_in_country_formatted'] =  number_format($data['total_amount_in_country'],2,".",",") . ' '.$conversion_rate->currency;
        $data['current_wallet_formatted'] = number_format($e_wallet,2,".",","). ' '.$conversion_rate->currency;
        $data['current_wallet_less_total_formatted'] = number_format($data['current_wallet_less_total'],2,".",","). ' '.$conversion_rate->currency;
        
        return $data;
    }

    public function break_down()
    {

        $data = $this->compute_transaction(Request::input('amount'));
        return view('member.break_down' , $data);
    }

    public function outlet_balance()
    {
        // $bal = EPayment::signIn('Process', 100);
        // return ($bal);
        // $test = {"data":{"transactionNumber":"PagIbig-13201508-000005","referenceNumber":"14","dateEntry":"2015-08-11T17:12:40.687"};
        
        // // dd({"responseCode":100,"remarks":"REQUESTACCEPTED","data":{"transactionNumber":"PagIbig-13201508-000005","referenceNumber":"14","dateEntry":"2015-08-11T17:12:40.687"}});

        // dd($test);

        // {"responseCode":100,"remarks":"REQUESTACCEPTED","data":{"transactionNumber":"PagIbig-13201508-000003","referenceNumber":"12","dateEntry":"2015-08-11T16:33:46.583"}}
    }


    public function save_code()
    {

        $data = Request::input('myData');
        $insert_data = null;
        foreach ($data as $key => $value)
        {
            if(array_key_exists('transaction_code', $value) && array_key_exists('description', $value))
            {
                $insert_data['transaction_code'] = $value['transaction_code'];
                $insert_data['description'] = $value['description'];

                $test_test = new Tbl_epayment_transation_code_list($insert_data);
                $test_test->save();

            }
        }

        return Tbl_epayment_transation_code_list::all();
    }







    

}



