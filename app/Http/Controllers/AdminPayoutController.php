<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use Crypt;
use App\Tbl_account_encashment_history;
use App\Classes\Admin;

class AdminPayoutController extends AdminController
{
	public function index()
	{
		$data["page"] = "Process Payout"; 
        return view('admin.transaction.payout');
	}

	public function data()
    {
    	$account = Tbl_account_encashment_history::where('status','Pending')->account()->get();

        foreach($account as $key => $a)
        {
            $account[$key]->total = $a->amount - $a->deduction;
        }

        // $account = Tbl_account::select('*')->where('tbl_account.archived', Request::input('archived'))->leftJoin("tbl_country","tbl_account.account_country_id", "=", "tbl_country.country_id");
        return Datatables::of($account)	->addColumn('Breakdown','<a href="javascript:">Breakdown</a>')
        								->addColumn('Process','<a href="javascript:" class="showmodal-p">Process</a>')
        								->make(true);
    }
}