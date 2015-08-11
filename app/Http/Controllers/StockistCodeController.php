<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_membership_code;
use Datatables;
use App\Classes\Stockist;

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




}
