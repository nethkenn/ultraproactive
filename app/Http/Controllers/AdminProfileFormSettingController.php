<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\EPayment;
use Request;
use App\Tbl_get_input; 

class AdminProfileFormSettingController extends AdminController
{
    public function index()
    {


        $data['_input_field'] = null;
        if(Request::isMethod('get') && Request::input('transaction_code'))
        {

            $_input_field= EPayment::get_field(Request::input('transaction_code'));
            $get_input = Tbl_get_input::where('transaction_code', Request::input('transaction_code'))->get();
            if($_input_field)
            {
                foreach ((array)$_input_field as $key => $value)
                {
                    $data['_input_field'][$key] = $value;
                    $data['_input_field'][$key]['behavior'] = 3;
                    $saved_input = Tbl_get_input::where('transaction_code', Request::input('transaction_code'))->where('inputfield_name', $value['name'])->first();
                    if($saved_input)
                    {
                        $data['_input_field'][$key]['behavior'] = $saved_input->behavior;
                    }
                }
            }

        }


        
        return view("admin.e_payment_settings.epayment_from_setting", $data);
    }


    public function save()
    {
        $input_field = Request::input('input_field');
        $transaction_code = Request::input('transaction_code');

        
        $latest_input = [];
        foreach ( (array) $input_field as $key => $value)
        {

            $value['transaction_code'] = $transaction_code;

            $find_input = Tbl_get_input::where('transaction_code', $transaction_code)
                                        ->where('inputfield_name', $value['inputfield_name'])
                                        ->first();

            if(!$find_input)
            {
                $Tbl_get_input = new Tbl_get_input($value);
                $Tbl_get_input->save();
            }
            else
            {
                $Tbl_get_input = Tbl_get_input::find($find_input->id);
                $Tbl_get_input->transaction_code = $value['transaction_code'];
                $Tbl_get_input->inputfield_name = $value['inputfield_name'];
                $Tbl_get_input->behavior = array_key_exists('behavior', $value) ?  $value['behavior'] : 1 ;
                $Tbl_get_input->input_type = $value['input_type'];
                $Tbl_get_input->save();
            }

            $latest_input[] = $value['inputfield_name'];
        }

        $current_input_field = Tbl_get_input::where('transaction_code', $transaction_code)->get();
        if($current_input_field && $latest_input)
        {   $test = null;
            foreach ($current_input_field as $key => $value)
            {   
                $in_array = in_array($value->inputfield_name, $latest_input);

                if($in_array === false)
                {
                    $delete_get_input = Tbl_get_input::find($value->id);
                    $delete_get_input->delete();
                }
            }
        }        

        return redirect()->back();
    }


}
