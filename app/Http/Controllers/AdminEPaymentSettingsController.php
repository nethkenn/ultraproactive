<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_exchange_rate;
use App\Tbl_service_charge;
use App\Tbl_country;

class AdminEPaymentSettingsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $data['_service_charge'] = Tbl_service_charge::all();
        $_country = Tbl_country::all();



        if($_country)
        {
            foreach ($_country as $key => $value)
            {
                $search_rate = Tbl_exchange_rate::where('country_id', $value->country_id)->first();
                if(!$search_rate)
                {
                    $new_rate_insert['country_id'] = $value->country_id;
                    $new_rate_insert['peso_rate'] = 0;
                    $new_rate = new Tbl_exchange_rate($new_rate_insert);
                    $new_rate->save();
                }


            }
        }

        $data['_exchange_rate'] = Tbl_exchange_rate::getCurrency()->get();
        return view('admin.e_payment_settings.epayment_settings',$data);

    }

    public function update()
    {


        $_service_charge = Request::input('service_charge');
        $_exchange_rate = Request::input('exchange_rate');

        if($_service_charge)
        {
            foreach ((array)$_service_charge as $key => $value)
            {
                $Tbl_service_charge = Tbl_service_charge::find($key);
                if($Tbl_service_charge)
                {
                    $Tbl_service_charge->value = $value;
                    $Tbl_service_charge->save();
                }
            }
        }

        if($_exchange_rate)
        {
            foreach ((array)$_exchange_rate as $key => $value)
            {

                Tbl_exchange_rate::where('country_id', $key)->update(['peso_rate' => $value]);
                
            }
        }


        return redirect()->back();




    }

}
