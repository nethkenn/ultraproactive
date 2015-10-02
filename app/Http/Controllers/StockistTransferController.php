<?php namespace App\Http\Controllers;
use Request;
use DB;
use App\Classes\Stockist;
use Redirect;
use Session;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_account;
use App\Tbl_slot;
use App\Tbl_product;
use Datatables;
use Validator;
use Crypt;
use Carbon\Carbon;
use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use App\Tbl_stockist_inventory;
use App\Classes\Globals;
use App\Tbl_product_code;
use App\Classes\Log;
use App\Tbl_stockist;
use App\Tbl_stockist_log;
class StockistTransferController extends StockistController
{
    public function index()
    {
        $data['_slot'] = Tbl_slot::account()->get();
        $data['_error'] = Session::get('message');
        $data['_success'] = Session::get('success');
        $data['stockist_log'] = Tbl_stockist_log::where('tbl_stockist_log.stockist_id',Stockist::info()->stockist_id)->join('tbl_stockist_user','tbl_stockist_user.stockist_user_id','=','tbl_stockist_log.stockist_user_id')->get();

        if(isset($_POST['amount']))
        {

            $owned = Tbl_stockist::where('stockist_id',Stockist::info()->stockist_id)->first()->stockist_wallet;
            $recipient = Tbl_slot::where('slot_id',Request::input('member'))->account()->first();
            if(Request::input('amount') == "")
            {
                return Redirect::to('stockist/transfer_wallet')->with('message','Please put an amount.');
            }
            else if(Request::input('amount') == 0)
            {
                return Redirect::to('stockist/transfer_wallet')->with('message','Please put an amount.');
            }
            else if(Request::input('amount') > 0)
            {
                if(Request::input('amount') <= $owned)
                {
                    $update['stockist_wallet'] = $owned - Request::input('amount');
                    // $update_recipient['slot_wallet'] = $recipient->slot_wallet + Request::input('amount');

                    Tbl_stockist::where('stockist_id',Stockist::info()->stockist_id)->update($update);
                    // Tbl_slot::where('slot_id',Request::input('member'))->update($update_recipient);
                    Log::slot(Request::input('member'),'Stockist '.Stockist::info()->stockist_un.' transferred '.Request::input('amount').' amount to your wallet.',Request::input('member')); 


                    Log::stockist(Stockist::info()->stockist_id,Stockist::info()->stockist_user_id,"Amount of ".number_format(Request::input('amount'),2)." is transferred to ".$recipient->account_name." Slot #".Request::input('member').".");
                    return Redirect::to('stockist/transfer_wallet')->with('success','Transfer Complete');
                }
                else
                {
                    return Redirect::to('stockist/transfer_wallet')->with('message','Cannot transfer amount that is higher than your remaining balance.');
                }
            }
            else
            {
                return Redirect::to('stockist/transfer_wallet')->with('message','Negative amount is not allowed.');
            }
        }

        return view('stockist.transfer.transfer', $data);
    }
}
