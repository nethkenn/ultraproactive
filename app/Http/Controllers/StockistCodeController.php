<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_membership_code;
use Datatables;
use App\Classes\Stockist;
use App\Classes\Globals;

use App\Tbl_membership;
use App\Tbl_code_type;
use App\Tbl_product_package;
use App\Tbl_account;
use App\Tbl_inventory_update_type;
use App\Tbl_product_package_has;
use Validator;


class StockistCodeController extends StockistController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('stockist.membership_code.stockist_membership_code');
    }



    public function ajax_get_membership_code()
    {

        $stat = Request::input('status');
        $membership_code = Tbl_membership_code::byStockist(Stockist::info()->stockist_id)->getMembership()->getCodeType()->getPackage()->getInventoryType()->getUsedBy()->where(function ($query) use ($stat) {

            switch ($stat)
            {
                case 'unused':

                    $query->where('tbl_membership_code.blocked',0)->where('tbl_membership_code.used',0)->whereNotNull('tbl_account.account_id');
                    break;

                case 'used':
                    $query->where('tbl_membership_code.blocked',0)->where('tbl_membership_code.used',1)->whereNotNull('tbl_account.account_id');
                    break;

                case 'blocked':
                    $query->where('tbl_membership_code.blocked',1);
                    break;
                    
                default:
                      $query->where('tbl_membership_code.blocked',0)->where('tbl_membership_code.used',0)->whereNull('tbl_account.account_id');
      
            }


        })->get();

        return Datatables::of($membership_code) 

        ->addColumn('delete','<a href="#" class="block-membership-code" membership-code-id ="{{$code_pin}}">BLOCK</a>')
                                        ->addColumn('transfer','<a class="transfer-membership-code"  href="#" membership-code-id="{{$code_pin}}" account-id="{{$account_id}}">TRANSFER</a>')
                                        ->editColumn('created_at','{{$created_at->format("F d, Y g:ia")}}')
                                        ->editColumn('inventory_update_type_id','<input type="checkbox" {{$inventory_update_type_id == 1 ? \'checked="checked"\' : \'\'}} name="" value="" readonly disabled>')
                                        ->editColumn('account_name','{{$account_name or "No owner"}}')
                                        ->make(true);
    }

    public function add_code()
    {
        $data['_error'] = null;
        $data['_membership'] = Tbl_membership::where('membership_entry', 1)->get();
        $data['_code_type'] = Tbl_code_type::where('code_type_id', '!=' , 2)->get();
        $data['_prod_package'] = Tbl_product_package::all();
        $data['_account'] = Tbl_account::all();
        $data['_inventory_update_type'] = Tbl_inventory_update_type::all();


        return view('stockist.membership_code.stockist_membership_code_add', $data);
    }

    public function create_code()
    {
        $request_membership_id = Request::input('membership_id');
        $request_code_type_id = Request::input('code_type_id');
        $request_product_package_id = Request::input('product_package_id');
        $request_account_id = Request::input('account_id');
        $request_code_multiplier = Request::input('code_multiplier');
        $request_inventory_update_type_id = Request::input('inventory_update_type_id');


        $rules['code_type_id'] = 'required|exists:tbl_code_type,code_type_id';
        $rules['product_package_id'] = 'required|exists:tbl_product_package,product_package_id,membership_id,'.Request::input('membership_id').'|foo:'.Request::input('inventory_update_type_id');
        $rules['inventory_update_type_id'] = 'required|exists:tbl_inventory_update_type,inventory_update_type_id';
        $rules['account_id'] = 'required|exists:tbl_account,account_id';
        $rules['code_multiplier'] = 'min:1|integer';
        $rules['membership_id'] = 'required|exists:tbl_membership,membership_id|check_member';

        $message['product_package_id.foo'] = "One or more included product might be out of stock".
        $message['product_package_id.check_member'] = "This membership is not for Member entry".


        

        $this->custom_validate();

        $validator = Validator::make(Request::input(),$rules, $message);
        
        if ($validator->fails())
        {
            return redirect()   ->back()
                                ->withErrors($validator)
                                ->withInput();
        }



                        for ($i=0; $i < Request::input('code_multiplier'); $i++)
                {   

                    /**
                    * INSERT TO Tbl_membership_code
                    */
                    $name =DB::table('tbl_account')->where('account_username',Session::get('admin')['username'])->first();
                    $membership_code = new Tbl_membership_code(Request::input());
                    $membership_code->code_activation = Globals::create_membership_code();
                    //IF code_type_id IS FREE SLOT / 2 SET PRODUCT PACKAGE TO NULL
                    // if(Request::input('code_type_id')==2 || Request::input('inventory_update_type_id') == 3)
                    if(Request::input('code_type_id')==2)
                    {
                        $membership_code->product_package_id = null;
                    }
                    $membership_code->generated_by = Admin::info()->account_id;
                    $membership_code->account_id =  Request::input('account_id') ?: null;
                    $membership_code->created_at = Carbon::now();
                    $membership_code->save();

                    /**
                    * INSERT TO Rel_membership_code history
                    */
                    $insert['code_pin'] = $membership_code->code_pin;
                    $insert['by_account_id'] = $name->account_id;
                    $insert['to_account_id'] = $membership_code->account_id;
                    $insert['updated_at'] = $membership_code->created_at;
                    $insert['description'] = "Created by ".$name->account_name;
                    DB::table("tbl_member_code_history")->insert($insert);

                    /**
                     * INSERT TO Rel_membership_code
                     */
                    $insert2['code_pin'] = $membership_code->code_pin;
                    $insert2['product_package_id'] = Request::input('product_package_id');
                    Rel_membership_code::insert($insert2);


                    $membership_total_amount = $membership_total_amount + $selected_membership->membership_price; 
                    $sale[] = $membership_code->code_pin;



                }
        
    }


    public function custom_validate()
    {
        Validator::extend('check_member', function($attribute, $value, $parameters)
        {

            $membership = Tbl_membership::find($value);
            if($membership)
            {
                return true;
            }
            else
            {
                return $membership->membership_entry == 1;
            }

        });

        /**
         * CHECK PRODUCT INVENTORY
         */
        Validator::extend('foo', function($attribute, $value, $parameters)
        {
            $prod = Tbl_product_package_has::where('product_package_id', $value )->get();
            //IF inventory_update_type_id VALUE IS "DEDUCT RIGHT AWAY / 2" CHECK FOR INVENTORY
            if($parameters[0] == 2)
            {
                foreach ($prod as $key => $value)
                {
                    $prodpack = Tbl_product::find($value->product_id);


                    $deducted = $prodpack->stock_qty - $value->quantity; 
                    // die(var_dump($prodpack->stock_qty, $value->quantity, $deducted,  , ));

                    if($prodpack->stock_qty >= $value->quantity && $deducted >= 0)
                    {
                        return true;
                    }

                    else
                    {
                        return false;
                    }   
                }
            }
            else
            {
                return true;
            }                   
        });
    }








}
