<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\EPayment;
use Request;


class EPayController extends MemberController
{

 

    public function index()
    {

        $data['_input_field'] = null;
        if(Request::isMethod('get') && Request::input('transaction_code'))
        {

            $data['_input_field'] = EPayment::get_field(Request::input('transaction_code'));

        }

        return view('member.epayment', $data);
    }

    public function process()
    {
        $validate = EPayment::validate_field(Request::input());
        $transaction_code = Request::input('transaction_code');
        if($validate['responseCode'] != 100)
        {
            $error = 'Response code #'.$validate['responseCode']. ' : '.$validate['remarks'];

            return redirect()->back()->withInput()->with('error', $error);
        }
        
        // $input['lastName'] = 'NATIVIDAD';
        // $input['firstName'] = 'HENRY';
        // $input['middleName'] = 'VILLANUEVA';
        // $input['birthDate'] = '05/06/1960';



        $transaction = EPayment::signIn('Process', $transaction_code, Request::input());
        return $transaction;

        


        

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





    

}



