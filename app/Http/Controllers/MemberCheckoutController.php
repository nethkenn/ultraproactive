<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Customer;
use App\Tbl_slot;
use App\Tbl_product;
use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use Session;
use Validator;
class MemberCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function checkout()
    {

        
        // $customer = Customer::info();

        // $slot= Tbl_slot::where('slot_id', Request::input('slot_id'))->where('slot_owner', $customer->account_id)->first();
        // if($slot==null)
        // {
        //     $returnHTML  =  '<div class="col-md-12 alert alert-danger">'.
        //                 'Invalid User or Slot'.
        //            '</div>';

        // }
        // else
        // {


        //     if(isset($_POST['slot_id']))
        //     {
                
        //     }


        //   $returnHTML = view('member.checkout')->render();
             
        // }



        $data['_error'] = null;
        $customer = Customer::info();
        $slot = Tbl_slot::where('slot_id', Request::input('slot_id'))->where('slot_owner', $customer->account_id)->first();
        $data['slot'] = $slot;
        $cart = Session::get('cart');
        $data['final_total'] = $this->get_final_total($cart);
        $data['remaining_bal'] = $slot->slot_wallet - $data['final_total'];
        $data['pts'] = $this->get_product_point($cart);




        



        if(isset($_POST['slot_id']))
        {

            $validate_slot_wallet = $slot->slot_wallet >= $data['final_total'];
            $request['slot_id'] = Request::input('slot_id');
            $rules['slot_id'] = 'required|exists:tbl_slot,slot_id,slot_owner,'.$customer->account_id;

            $request['slot_wallet'] = $validate_slot_wallet;
            $rules['slot_wallet'] = 'accepted';

            $message = [
                            'slot_wallet.accepted' => 'Not enough :attribute'
                        ];


            $validator = $validator = Validator::make($request, $rules, $message);
            if($validator->fails())
            {
                $data['_error'] = $validator->errors()->all();
                // dd( $data['_error'] );
            }
            else
            {
                $insert['slot_id'] = Request::input('slot_id');
                $insert['voucher_code'] = $this->check_code();
                $insert['total_amount'] = $data['final_total'];
                Tbl_slot::where('slot_id',Request::input('slot_id') )->update(['slot_wallet'=>$data['remaining_bal']]);             
                $voucher = new Tbl_voucher($insert);
                $voucher->save();



                dd($voucher);
            }        
        }

        $returnHTML = view('member.checkout', $data)->render();
             



            
        return $returnHTML;

    }



    public function code_generator()
    {
        
        $chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 8; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        return $res;

    }


    public function check_code()
    {

        $stop=false;
        while($stop==false)
        {
            $code = $this->code_generator();

            $check = Tbl_voucher::where('voucher_code', $code )->first();
            if($check==null)
            {
                $stop = true;
            }
        }

        return $code;
    }






    public function get_product_point($cart)
    {
        $pts['unilevel'] = 0;
        $pts['binary'] = 0;
        if($cart)
        {
            foreach ($cart as $key => $value)
            {
                $unilevel_pts =  Tbl_product::select('unilevel_pts')->where('product_id', $key)->first()->unilevel_pts;
                $binary_pts =  Tbl_product::select('binary_pts')->where('product_id', $key)->first()->binary_pts;


                $pts['unilevel'] = $pts['unilevel'] + $unilevel_pts;
                $pts['binary'] = $pts['binary'] + $binary_pts;

            }          
        }

   
        return $pts;

    }


    public function get_final_total($cart)
    {
        $total = 0;
        if($cart)
        {
            foreach ($cart as $key => $value)
            {
                $total = $total + $value['total'];

            }          
        }

   
        return $total;

    }
}