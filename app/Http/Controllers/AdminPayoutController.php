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



        if(isset($_POST['processall']))
        {
            dd("sample");
        }



















        if(Request::input('Proccessed') == 1)
        {
            $request = 'Proccessed';
        }
        else
        {
            $request = 'Pending';
        }
        $account = Tbl_account_encashment_history::selectRaw('tbl_account_encashment_history.account_id, sum(amount) as sum')
                                                ->account()
                                                ->selectRaw('tbl_account.account_name, tbl_account.account_name')
                                                ->selectRaw('tbl_account_encashment_history.account_id, sum(deduction) as deduction')
                                                ->selectRaw('count(*) as count, slot_id')
                                                ->selectRaw('tbl_account_encashment_history.account_id, tbl_account_encashment_history.account_id')
                                                ->selectRaw('type, type')
                                                ->where('status',$request)
                                                ->groupBy('account_id')
                                                ->groupBy('type')
                                                ->get();  

            foreach($account as $key => $a)
            {
                if(!isset($account[$key]->total))
                {
                    $account[$key]->total = ($a->sum - $a->deduction); 
                }
                else
                {
                    $account[$key]->total =  ($account[$key]->total + $a->sum) - $a->deduction; 
                }
                 $account[$key]->json = json_encode(Tbl_account_encashment_history::where('account_id',$a->account_id)->where('status','Pending')->where('type',$a->type)->get());
                 
                 $d  = Tbl_account_encashment_history::where('account_id',$a->account_id)->orderBy('encashment_date','DESC')->where('status','Pending')->where('type',$a->type)->first();
                 $account[$key]->date = $d->encashment_date;   
            }
        $data['data'] = $account;   

        return view('admin.transaction.payout',$data);
	}

	// public function data()
 //    {



 //        // $account = Tbl_account::select('*')->where('tbl_account.archived', Request::input('archived'))->leftJoin("tbl_country","tbl_account.account_country_id", "=", "tbl_country.country_id");
 //        return Datatables::of($new)	->addColumn('Breakdown','<a href="javascript:">Breakdown</a>')
 //        								->addColumn('Process','<a href="javascript:" class="showmodal-p" request="{{$account->account_name}}">Process</a>')
 //        								->make(true);
 //    }
}