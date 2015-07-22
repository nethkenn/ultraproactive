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
use App\Classes\Globals;
use App\Tbl_product_code;
class MemberCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function checkout()
    {
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
            $cart_count = count($cart) >= 1;



            /**
             * VALIDATOR REQUEST PRODUCT CART
             */
            foreach( (array)$cart as $key => $val)
            {

                $request['product_'.$key] = $key;


            }


             /**
             * VALIDATOR RULES PRODUCT CART
             */
            foreach( (array)$cart as $key => $val)
            {

                $product = Tbl_product::where('product_id', $key)->first();
                $rules['product_'.$key] = 'integer|has_stock:'.$product->stock_qty .','. $val['qty'];

            }

            $request['slot_id'] = Request::input('slot_id');
            $rules['slot_id'] = 'required|exists:tbl_slot,slot_id,slot_owner,'.$customer->account_id;

            $request['slot_wallet'] = $validate_slot_wallet;
            $rules['slot_wallet'] = 'accepted';

            $request['cart'] = $cart_count;
            $rules['cart'] = 'accepted';

            $message = [
                            'slot_wallet.accepted' => 'Not enough :attribute',
                            'cart.accepted' => 'The :attribute is empty.'
                        ];

            /**
             * VALIDATOR MESSAGE PRODUCT CART
             */
            foreach((array)$cart as $key => $val)
            {
                    
                $message['product_'.$key.'.has_stock'] = 'The :attribute has unsufficient stock.';

            }  



            Validator::extend('has_stock', function($attribute, $value, $parameters)
            {
        
                $stock_qty = $parameters[0];
                $cart_qty = $parameters[1];
                $stock_minus_cart_qty = $stock_qty-$cart_qty;

                if($stock_qty < $cart_qty || $stock_minus_cart_qty < 0)
                {
                    
                   
                    $cart = Session::get('cart');
                    unset($cart[$value]);
                    Session::forget('cart');
                    Session::put('cart',$cart );
                    return false;

                }
                else
                {
                    return $value;
                }
            });


            

            $validator = Validator::make($request, $rules, $message);
            if($validator->fails())
            {
                $data['_error'] = $validator->errors()->all();
            }
            else
            {
                $insert['slot_id'] = Request::input('slot_id');

                $query = Tbl_voucher::where('voucher_code', Globals::code_generator())->first();
                $insert['voucher_code'] = Globals::check_code($query);

                $insert['total_amount'] = $data['final_total'];
                $insert['account_id'] = $customer->account_id;
                Tbl_slot::where('slot_id',Request::input('slot_id') )->lockForUpdate()->update(['slot_wallet'=>$data['remaining_bal']]);             
                



                $voucher = new Tbl_voucher($insert);
                $voucher->save();

                foreach ((array)$cart as $key => $value)
                {
   
                    $prod_pts = Tbl_product::find($key);
                    $insert_prod =  array(
                        'product_id' =>  $key,
                        'voucher_id'=> $voucher->voucher_id,
                        'price' => $value['price'],
                        'qty'=> $value['qty'],
                        'sub_total' => $value['total'],
                        'binary_pts' => $prod_pts->binary_pts,
                        'unilevel_pts' => $prod_pts->unilevel_pts
                    );

                    // $product = Tbl_product::find($key);
                    // $updated_stock_qty = $product->stock_qty - $value['qty'];
                    // Tbl_product::where('product_id', $key)->lockForUpdate()->update(['stock_qty'=>$updated_stock_qty]);

                    $voucher_has_product = new Tbl_voucher_has_product($insert_prod);
                    $voucher_has_product->save();

                    // dd($voucher_has_product->voucher_item_id);
                    $query = Tbl_product_code::where('code_activation', Globals::code_generator())->first();
                    $insert_prod_code['code_activation'] = Globals::check_code($query);
                    $insert_prod_code['voucher_item_id'] = $voucher_has_product->voucher_item_id;
                    
                    $product_code = new Tbl_product_code($insert_prod_code);
                    $product_code->save();



                }



                Session::put('cart',[]);


                return '<div class="col-ms-12">
                          <p class="col-ms-12 alert alert-success">
                            Checkout Successfull!!!
                          </p>
                              <a  id="back-to-product" href="#" class="btn btn-default">Return to Product page</a>
                              <a class="btn btn-default" href="/member/voucher">View Vouchers</a>
                        </div>';



            }        
        }
             

            
        return view('member.checkout', $data);

    }



    // public function code_generator()
    // {
        
    //     $chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    //     $res = "";
    //     for ($i = 0; $i < 8; $i++) {
    //         $res .= $chars[mt_rand(0, strlen($chars)-1)];
    //     }

    //     return $res;

    // }


    // public function check_code()
    // {

    //     $stop=false;
    //     while($stop==false)
    //     {
    //         $code = $this->code_generator();

    //         $check = Tbl_voucher::where('voucher_code', $code )->first();
    //         if($check==null)
    //         {
    //             $stop = true;
    //         }
    //     }

    //     return $code;
    // }






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