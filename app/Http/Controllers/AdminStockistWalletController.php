<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Tbl_stockist_user;
use App\Tbl_stockist;
use Datatables;
use Crypt;
use Validator;
use Session;
class AdminStockistWalletController extends AdminController
{
	public function index()
	{
		$data['_stockist'] = Tbl_stockist::all();
        $data['_success'] = Session::get('success');
        if(isset($_POST['proccess']))
        {
           $stock = Tbl_stockist::where('stockist_id',Request::input('stockist'))->first();
           $stock = $stock->stockist_wallet + Request::input('amount');
           Tbl_stockist::where('stockist_id',Request::input('stockist'))->update(['stockist_wallet'=>$stock]);
           return Redirect::to('admin/stockist_wallet')->with('success','Transfer Complete');
        }
		return view('admin.maintenance.stockist_wallet',$data);
	}

}