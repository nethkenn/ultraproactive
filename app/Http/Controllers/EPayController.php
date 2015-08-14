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
use App\Tbl_agentRefNo;
use App\Tbl_epayment_transaction;
use App\Tbl_response_data;
use Carbon\Carbon;
use App\Tbl_account;

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


        $req_param = Request::input('param');
        $transaction_code = Request::input('transaction_code');

        /*GENERATE agentRefNo*/
        $new_agentRefNo = new Tbl_agentRefNo();
        $new_agentRefNo->transaction_code = $transaction_code;
        $new_agentRefNo->account = Customer::info()->account_id;
        $new_agentRefNo->save();

        /*SET agentRefNo*/
        $agentRefNo = $new_agentRefNo->agentRefNo;
        $req_param['agentRefNo'] = $agentRefNo;
        
        
        $validate = EPayment::validate_field(Request::input('transaction_code'), $req_param);
        
        if($validate['responseCode'] != 100)
        {
            /*DELETE agentRefNo IF THE TRANSACTION DID NOT PASS TO VENTAJA VALIDATION*/
            Tbl_agentRefNo::where('agentRefNo', $agentRefNo)->delete();
            $error = 'Response code #'.$validate['responseCode']. ' : '.$validate['remarks'];
            return redirect()->back()->withInput()->with('error', $error);
        }




        $transaction_breakdown = $this->compute_transaction($req_param['amount']);
        /*CHECK IF E-WALLET IS ENOUGH*/
        if($transaction_breakdown['current_wallet_less_total'] < 0 )
        {
            Tbl_agentRefNo::where('agentRefNo', $agentRefNo)->delete();
            $error = "Your current E-wallet balance is not enough.";
            return redirect()->back()->withInput()->with('error', $error);
        }
    
        //dd({"responseCode":100,"remarks":"REQUESTACCEPTED","data":{"transactionNumber":"PagIbig-13201508-000005","referenceNumber":"14","dateEntry":"2015-08-11T17:12:40.687"}});
        
        /*SAVE TO Tbl_agentRefNo*/
        $transaction = EPayment::signIn('Process', $transaction_code, $req_param );
        $update_agentRefNo = Tbl_agentRefNo::find($agentRefNo);
        $update_agentRefNo->transaction_code = $transaction_code;
        $update_agentRefNo->responseCode = array_key_exists('responseCode', $transaction) ? $transaction['responseCode'] : null;
        $update_agentRefNo->remarks = array_key_exists('remarks', $transaction) ? $transaction['remarks'] : null;
        if(array_key_exists('data', $transaction) && $transaction['data'] != null)
        {
            $update_agentRefNo->data = serialize($transaction['data']);
        }
        $update_agentRefNo->save();

        if($transaction['responseCode'] != 100)
        {
            dd('THERE WAS AN ERROR PROCESSING YOU\'RE TRANSACTION (agentRefNo #'. $agentRefNo .')', $transaction );
        }



        $insert_transaction['agentRefNo'] = $agentRefNo;
        $insert_transaction['country'] = Customer::info()->account_country_id;
        $insert_transaction['account'] = Customer::info()->account_id;
        $insert_transaction['transaction'] = $transaction_code;
        $insert_transaction['rate_peso'] = $transaction_breakdown['exchange_rate'];
        $insert_transaction['service_charge'] = $transaction_breakdown['service_charge'];
        $insert_transaction['amount'] = $transaction_breakdown['amount'];
        $insert_transaction['total_amount'] = $transaction_breakdown['total_amount'] ;
        $insert_transaction['total_amount_in_country']= $transaction_breakdown['total_amount_in_country'];
        $insert_transaction['e_wallet'] = $transaction_breakdown['current_wallet'];
        $insert_transaction['e_wallet_less_total'] = $transaction_breakdown['current_wallet_less_total'];


        $new_transaction = new Tbl_epayment_transaction($insert_transaction);
        $new_transaction->save();

        $e_wallet_update = Tbl_account::find(Customer::info()->account_id);
        $e_wallet_update->e_wallet = $transaction_breakdown['current_wallet_less_total'];
        $e_wallet_update->save();

        if(array_key_exists('data', $transaction) && $transaction['data'] != null)
        {
            foreach ($transaction['data'] as $key => $value)
            {
                $insert_response_data['agentRefNo'] = $agentRefNo;
                $insert_response_data['data_name'] = $key;
                $insert_response_data['data_value'] = $value;
                $response_data = new Tbl_response_data($insert_response_data);
                $response_data->save();
            }        
        }

        // dd($transaction_code, $req_param, $transaction, $new_transaction) ;
        $message = 'You\'re transaction has been successfull. View AGENT REF #'.$new_transaction->agentRefNo.' for details.';
        return redirect('member/e-payment/transaction-log')->with('message',$message );






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
        // dd({"responseCode":100,"remarks":"REQUESTACCEPTED","data":{"transactionNumber":"PagIbig-13201508-000005","referenceNumber":"14","dateEntry":"2015-08-11T17:12:40.687"}});
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



