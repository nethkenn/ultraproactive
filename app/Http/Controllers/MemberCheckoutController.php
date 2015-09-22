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
use App\Classes\Product;
use App\Classes\Log;
use App\Tbl_wallet_logs;
use App\Tbl_product_discount;

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
        $slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                                        ->where('slot_id', Request::input('slot_id'))
                                                                        ->where('slot_owner', $customer->account_id)
                                                                        ->first();
        $data['slot'] = $slot;
        $data['current_wallet'] = Tbl_wallet_logs::id(Request::input('slot_id'))->wallet()->sum('wallet_amount');
        $gc =  Tbl_wallet_logs::id(Request::input('slot_id'))->gc()->sum('wallet_amount');
        $wallet = $data['current_wallet'];
        $cart = Session::get('cart');
        $sum_cart = $this->get_final_total($cart,$slot);
        $data['final_total'] = $sum_cart;
        $data['remaining_bal'] = $wallet - $data['final_total'];
        $data['remaining_bal_gc'] = $gc - $data['final_total'];
        $data['pts'] = $this->get_product_point($cart);
        $amt = 0 - $data['final_total'];

        if(isset($_POST['slot_id']) && isset($_POST['gc']))
        {
                $validate_slot_gc = $slot->slot_gc >= $data['final_total'];
                $cart_count = count($cart) >= 1;

                $request['slot_id'] = Request::input('slot_id');
                $rules['slot_id'] = 'required|exists:tbl_slot,slot_id,slot_owner,'.$customer->account_id;

                $request['slot_gc'] = $gc;
                $rules['slot_gc'] = 'check_wallet:'.$data['final_total'];

                $request['cart'] = $cart_count;
                $rules['cart'] = 'Integer|min:1';

                $message = [
                                'slot_gc.accepted' => 'Not enough :attribute',
                                'cart.accepted' => 'The :attribute is empty.'
                            ];


                $message['slot_gc.check_wallet'] = "Slot GC balance is not enough.";
                Validator::extend('check_wallet', function($attribute, $value, $parameters)
                {
                     $slot_gc = $value;
                     $voucher_total = $parameters[0];
                     $deducted = $slot_gc - $voucher_total;

                     if($slot_gc < $voucher_total || $deducted < 0)
                     {
                         return false;
                     }
                     else
                     {
                         return true;
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

                    $insert['voucher_code'] = Globals::create_voucher_code();

                    $insert ['discount'] = 0;
                    $insert['total_amount'] = 0;
                    $insert['account_id'] = $customer->account_id;
                    // Tbl_slot::where('slot_id',Request::input('slot_id') )->lockForUpdate()->update(['slot_gc'=>$data['remaining_bal_gc']]);             
                    
                   



                    $voucher = new Tbl_voucher($insert);
                    $voucher->save();
                    
                    $log = "Purchase Product worth ".Product::return_format_num($insert['total_amount']). " with Voucher Num: ".$voucher->voucher_id." , Voucher Code: ".$voucher->voucher_code.".";
                    Log::slot(Request::input('slot_id'), $log, $amt,"Purchase Product",Request::input('slot_id'),1);
                    Log::account($customer->account_id, $log);
                    $total = 0;
                    foreach ((array)$cart as $key => $value)
                    {
                        $discount = Tbl_product_discount::where('membership_id',$slot->slot_membership)->where('product_id',$key)->first();
                        if($discount)
                        {
                            $discount = $discount->discount;
                        }
                        else
                        {
                            $discount = 0;
                        }

                        $prod_pts = Tbl_product::find($key);
                        $value['total'] = $prod_pts->price *$value['qty'];
                        $discount_amount = ($discount/100)*$value['total'];
                        $value['total'] = $value['total'] + (($discount/100)*$value['total']);
                        $insert_prod =  array(
                            'product_id' =>  $key,
                            'voucher_id'=> $voucher->voucher_id,
                            'product_discount'=> $discount,
                            'price' => $value['price'],
                            'qty'=> $value['qty'],
                            'sub_total' => $value['total'],
                            'binary_pts' => $prod_pts->binary_pts * $value['qty'],
                            'unilevel_pts' => $prod_pts->unilevel_pts * $value['qty'],
                            'product_discount' => $discount,
                            'product_discount_amount' => $discount_amount,
                            'gc'=>1
                        );
                        $total = $total + $value['total'];
                        $voucher_has_product = new Tbl_voucher_has_product($insert_prod);
                        $voucher_has_product->save(); 


                    }

                    // Tbl_voucher::where('voucher_id',$voucher->voucher_id)->update(['total_amount'=>$total]);

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
        elseif(isset($_POST['slot_id']))
        {


            $validate_slot_wallet = $wallet >= $data['final_total'];
            $cart_count = count($cart) >= 1;


            $request['slot_id'] = Request::input('slot_id');
            $rules['slot_id'] = 'required|exists:tbl_slot,slot_id,slot_owner,'.$customer->account_id;

            $request['slot_wallet'] = $wallet;
            $rules['slot_wallet'] = 'check_wallet:'.$data['final_total'];

            $request['cart'] = $cart_count;
            $rules['cart'] = 'Integer|min:1';

            $message = [
                            'slot_wallet.accepted' => 'Not enough :attribute',
                            'cart.accepted' => 'The :attribute is empty.'
                        ];


            $message['slot_wallet.check_wallet'] = "Slot wallet balance is not enough.";
            Validator::extend('check_wallet', function($attribute, $value, $parameters)
            {
                 $slot_wallet = $value;
                 $voucher_total = $parameters[0];
                 $deducted = $slot_wallet - $voucher_total;

                 if($slot_wallet < $voucher_total || $deducted < 0)
                 {
                     return false;
                 }
                 else
                 {
                     return true;
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

                $insert['voucher_code'] = Globals::create_voucher_code();

                $insert ['discount'] = $slot->discount;
                $insert['total_amount'] = $data['final_total'];
                $insert['account_id'] = $customer->account_id;
                // Tbl_slot::where('slot_id',Request::input('slot_id') )->lockForUpdate()->update(['slot_wallet'=>$data['remaining_bal']]);             
                
                



                $voucher = new Tbl_voucher($insert);
                $voucher->save();
                
                $log = "Purchase Product worth ".Product::return_format_num($insert['total_amount']). " with Voucher Num: ".$voucher->voucher_id." , Voucher Code: ".$voucher->voucher_code.".";
                // Log::slot(Request::input('slot_id'), $log, $data['remaining_bal']);
                Log::slot(Request::input('slot_id'), $log, $amt, "Purchase Product",Request::input('slot_id'));
                Log::account($customer->account_id, $log);
                $total = 0;
                foreach ((array)$cart as $key => $value)
                {
                    $discount = Tbl_product_discount::where('membership_id',$slot->slot_membership)->where('product_id',$key)->first();
                    if($discount)
                    {
                        $discount = $discount->discount;
                    }
                    else
                    {
                        $discount = 0;
                    }

                    $prod_pts = Tbl_product::find($key);
                    $value['total'] = $prod_pts->price *$value['qty'];
                    $discount_amount = ($discount/100)*$value['total'];
                    $value['total'] = $value['total'] - (($discount/100)*$value['total']);
                    $insert_prod =  array(
                        'product_id' =>  $key,
                        'voucher_id'=> $voucher->voucher_id,
                        'price' => $value['price'],
                        'qty'=> $value['qty'],
                        'sub_total' => $value['total'],
                        'binary_pts' => $prod_pts->binary_pts * $value['qty'],
                        'unilevel_pts' => $prod_pts->unilevel_pts * $value['qty'],
                        'product_discount' => $discount,
                        'product_discount_amount' => $discount_amount
                    );
                    $total = $total + $value['total'];
                    // $product = Tbl_product::find($key);
                    // $updated_stock_qty = $product->stock_qty - $value['qty'];
                    // Tbl_product::where('product_id', $key)->lockForUpdate()->update(['stock_qty'=>$updated_stock_qty]);

                    $voucher_has_product = new Tbl_voucher_has_product($insert_prod);
                    $voucher_has_product->save();
                    
                    /**
                     * FOREACH ITEM QUANTITY CREATE PRODUCT CODE
                     */
                    for ($x = 0 ; $x < $value['qty']; $x++)
                    {

                        $insert_prod_code['code_activation'] = Globals::create_product_code();
                        $insert_prod_code['voucher_item_id'] = $voucher_has_product->voucher_item_id;

                        $product_code = new Tbl_product_code($insert_prod_code);
                        $product_code->save();
                    } 


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


                $pts['unilevel'] = $pts['unilevel'] + $unilevel_pts * $value['qty'] ;
                $pts['binary'] = $pts['binary'] + $binary_pts * $value['qty'];

            }

   
        }

   
        return $pts;

    }


    public function get_final_total($cart,$slot)
    {
        $total = 0;
        if($cart)
        {
            foreach ($cart as $key => $value)
            {
                $discount = Tbl_product_discount::where('product_id',$key)->where('membership_id',$slot->slot_membership)->first();

                if($discount)
                {
                    $discount = $discount->discount;
                }
                else
                {
                    $discount = 0;
                }
                $sub_total =   $value['total'] - (($discount/100)*$value['total']);
                $total = $total + $sub_total;
            }          
        }

        return $total;
    }



    
}