<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_epayment_transation_code_list;
use App\Tbl_get_input;
use App\Classes\EPayment;
use App\Tbl_transaction_profile;
use Validator;
use App\Tbl_transaction_profile_input;
use Datatables;
use App\Classes\Customer;

class MemberEpaymentRecipientController extends MemberController
{

    public function index()
    {
        return view('member.epayment_recipient');
    }


    public function get_data()
    {

        $transaction_profile = Tbl_transaction_profile::where('account', Customer::info()->account_id)->get();

        return Datatables::of($transaction_profile)
    
                            ->addColumn('edit_delete','<a href="member/e-payment/recipient/edit?transaction_code={{$transaction_code}}&id={{$id}}">EDIT</a> | <a style="cursor:pointer;" class="delete-profile" id="{{$id}}">DELETE</a> | <a style="cursor:pointer;"  href=member/e-payment/?transaction_code={{$transaction_code}}&form_id={{$id}}> USE</a>')
                            ->make(true);
    }

    public function add()
    {   

        $data['_input_field'] = null;
        if(Request::isMethod('get') && Request::input('transaction_code'))
        {

            $check_if_save = Tbl_get_input::where('transaction_code', Request::input('transaction_code'))->count();

            if($check_if_save > 0 )
            {

                $data['_input_field'] = EPayment::get_field(Request::input('transaction_code'));
                if($data['_input_field'])
                {
                    foreach ($data['_input_field'] as $key => $value)
                    {
                        $is_constant = Tbl_get_input::where('transaction_code', Request::input('transaction_code'))->where('inputfield_name', $value['name'])->where('behavior', 1)->count();
                        if($is_constant === 0)
                        {
                            unset($data['_input_field'][$key]);
                        }
                    }
                }
            }

             
        }



        $data['_request_code'] = Tbl_epayment_transation_code_list::getFront()->get();
        return view('member.epayment_recipient_add', $data);


    }

    public function save()
    {
        $requests['account'] = Customer::info()->account_id;

        $requests['transaction_code'] = Request::input('transaction_code');
        $rules['transaction_code'] = 'required|exists:tbl_epayment_transation_code_list,transaction_code';
        
        $requests['profile_name'] = Request::input('profile_name');
        $rules['profile_name'] = 'required|unique:tbl_transaction_profile,profile_name';


        foreach ( (array) Request::input('req') as $key => $value)
        {
            $requests['req['.$key.']'] = $value;
        }

        foreach ( (array) Request::input('req') as $key => $value)
        {
            $rules['req['.$key.']'] = 'required';
        }
        
        $validator = Validator::make($requests, $rules);


        if ($validator->fails())
        {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $transaction_profile = new Tbl_transaction_profile($requests);
        $transaction_profile->save();

        if(Request::input('req'))
        {
            foreach ( (array) Request::input('req') as $key => $value)
            {
                $get_input = Tbl_get_input::where('inputfield_name', $key)->where('transaction_code', Request::input('transaction_code'))->first();
                
                $insert_input['profile_id'] = $transaction_profile->id;
                $insert_input['input_id'] = $get_input->id;
                $insert_input['value'] = $value;


                $transaction_profile_input = new Tbl_transaction_profile_input($insert_input);
                $transaction_profile_input->save();
            }
        }

        return redirect('member/e-payment/recipient');


       
    }

    public function edit()
    {
        $data['_input_field'] = null;
        $data['profile'] = Tbl_transaction_profile::findOrFail(Request::input('id'));

        if(Request::isMethod('get') && Request::input('transaction_code'))
        {

            $check_if_save = Tbl_get_input::where('transaction_code', Request::input('transaction_code'))->count();

            if($check_if_save > 0 )
            {

                $_input_field = EPayment::get_field(Request::input('transaction_code'));
                if($_input_field)
                {
                    foreach ($_input_field as $key => $value)
                    {

                        $data['_input_field'][$key] = $value;
                        $input_value = Tbl_transaction_profile_input::getInput()->where('profile_id',Request::input('id'))->where('inputfield_name', $value['name'] )->first();
                        if($input_value)
                        {
                            $input_value = $input_value->value;
                            $test[] = $input_value;

                            $data['_input_field'][$key]['value'] = $input_value;
                        }
                        else
                        {
                            $data['_input_field'][$key]['value'] = null;
                        }

                        $is_constant = Tbl_get_input::where('transaction_code', Request::input('transaction_code'))->where('inputfield_name', $value['name'])->where('behavior', 1)->count();
                        if($is_constant === 0)
                        {
                            unset($data['_input_field'][$key]);
                        }

                        
                    }

                };
            }

             
        }
        $data['_request_code'] = Tbl_epayment_transation_code_list::getFront()->get();

        return view('member.epayment_recipient_edit', $data);

    }

    public function update()
    {
        $id = Request::input('id');
        $transaction_profile = Tbl_transaction_profile::findOrFail($id);
        $requests['account'] = Customer::info()->account_id;

        // $requests['transaction_code'] = Request::input('transaction_code');
        // $rules['transaction_code'] = 'required|exists:tbl_epayment_transation_code_list,transaction_code';
        $requests['profile_name'] = Request::input('profile_name');
        $rules['profile_name'] = 'required|unique:tbl_transaction_profile,profile_name,'.$id;


        foreach ( (array) Request::input('req') as $key => $value)
        {
            $requests['req['.$key.']'] = $value;
        }

        foreach ( (array) Request::input('req') as $key => $value)
        {
            $rules['req['.$key.']'] = 'required';
        }
        
        $validator = Validator::make($requests, $rules);


        if ($validator->fails())
        {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $transaction_profile->profile_name = $requests['profile_name'];
        $transaction_profile->save();


        if(Request::input('req'))
        {
            foreach ( (array) Request::input('req') as $key => $value)
            {                
                Tbl_transaction_profile_input::getInput()->where('profile_id', $id)->where('inputfield_name', $key )->update(['value' => $value]);
            }
        }
        return redirect('member/e-payment/recipient');

    }

    public function delete()
    {
        $data['errors'] = null;
        $data['transaction_profile'] = null;
        $id = $requests['id'] = Request::input('id');
        $rules['id'] = 'required|exists:tbl_transaction_profile,id,id,'.Customer::info()->account_id;
        $validator = Validator::make($requests, $rules);


        if ($validator->fails())
        {   

            $data['errors'] = $validator->errors()->first('id');
        }
        else
        {
            $transaction_profile = Tbl_transaction_profile::findOrFail($id);
            $transaction_profile->delete();
            $data['transaction_profile'] = $transaction_profile;
        }


        return json_encode($data);

    }


    
}
