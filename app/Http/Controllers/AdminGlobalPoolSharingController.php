<?php namespace App\Http\Controllers;

use DB;
use Request;
use Crypt;
use App\Tbl_slot;
use App\Tbl_hack;
use App\Tbl_account;
use App\Classes\Compute;
use App\Classes\Admin;
use App\Classes\Log;
use Carbon\Carbon;
use App\Tbl_membership;
class AdminGlobalPoolSharingController extends AdminController
{
	public function index()
	{
		$data["page"] = "Global Pool Sharing";
		$data['gps'] = DB::table('tbl_settings')->where('key','=','global_pv_sharing_percentage')->first()->value;
        $data['total_pv'] = DB::table('tbl_global_pv_logs')->where('done',0)->sum('value');
        $data['shared'] = ($data['gps']/100 )* $data['total_pv'];

		if(isset($_POST['sbmt']))
		{
			// ignore_user_abort(true);
			// set_time_limit(0);
			// $strURL = "admin/transaction/global_pool_sharing";
			// header("Location: $strURL", true);
			// header("Connection: close", true);
			// header("Content-Encoding: none\r\n");
			// header("Content-Length: 0", true);


			// flush();
			// ob_flush();

			// session_write_close();

			$this->shared_distribution();
			DB::table('tbl_global_pv_logs')->where('done',0)->update(['done'=>1,'updated_at'=>Carbon::now()]);
			
			// sleep(5);
			// exit;
		}

        return view('admin.transaction.global_pool_sharing', $data);
	}

	public function shared_distribution()
	{
		$data['gps'] = DB::table('tbl_settings')->where('key','=','global_pv_sharing_percentage')->first()->value;
        $data['total_pv'] = DB::table('tbl_global_pv_logs')->where('done',0)->sum('value');
        $shared = ($data['gps']/100 )* $data['total_pv'];	

        $membership = Tbl_membership::where('archived',0)->where('global_pool_sharing','!=',0)->get();

        foreach($membership as $key => $m)
        {
        	$amount_to_shared = ($m->global_pool_sharing/100)*$shared;
        	$slot = Tbl_slot::where('slot_membership',$m->membership_id)->membership()->get();
        	$count = Tbl_slot::where('slot_membership',$m->membership_id)->count();
        	$divided_amount = $amount_to_shared / $count;
    		if($divided_amount != 0)
    		{
	        	foreach($slot as $keys => $s)
	        	{
		            /* INSERT LOG */
		            $log = "Your slot #".$s->slot_id." gain an amount of <b>".number_format($divided_amount,2)." wallet </b> you earned from Global Pool Sharing. (".$data['gps']."% of ".$data['total_pv']." equal to ".number_format($amount_to_shared,2)." and shared to all ".$count." ".$m->membership_name.", ".number_format($divided_amount,2)." each).";
		            Log::slot($s->slot_id, $log, $divided_amount, "Use code",$s->slot_id);
	        	}	
    		}
        }
	}


}