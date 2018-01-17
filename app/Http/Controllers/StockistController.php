<?php namespace App\Http\Controllers;
use Request;
use DB;
use App\Classes\Stockist;
use Redirect;
use Session;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_stockist;
class StockistController extends Controller
{
	public function __construct()
	{
	   // dd("STOCKIST UNDER MAINTENANCE");
        $user = Stockist::info();
       
        if($user)
        {
            $wallet = Tbl_stockist::where('stockist_id',$user->stockist_id)->first();
            View()->share("user", $user);   
            View()->share("wallet", $wallet->stockist_wallet);       
        }
        else
        {
            return Redirect::to("stockist/login")->send();
        }
	}
}
