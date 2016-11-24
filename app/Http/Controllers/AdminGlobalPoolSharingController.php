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
use App\Tbl_pv_logs;
use App\Tbl_transaction;
use App\Tbl_compensation_rank;
use Redirect;
class AdminGlobalPoolSharingController extends AdminController
{
	public function index()
	{
		$data['settings_for_global'] = DB::table('tbl_settings')->where('key','settings_for_global')->first();
		$data["page"]     = "Global Pool Sharing";
		$data['gps']      = DB::table('tbl_settings')->where('key','=','global_pv_sharing_percentage')->first()->value;
        $data['total_pv'] = $this->compute_gained_pv();
        $data['shared']   = ($data['gps']/100 )* $data['total_pv'];
		$data['check']    = DB::table('tbl_settings')->where('key','global_enable')->first();
		$_slot            = DB::table("tbl_slot")->join("tbl_compensation_rank","compensation_rank_id","=","tbl_slot.permanent_rank_id")->where("compensation_rank_percentage","!=",0)->where("removed_from_gps",0)->get();
		foreach($_slot as $key => $slot)
		{
			$_slot[$key]->account_name = DB::table("tbl_account")->where("account_id",$slot->slot_owner)->first()->account_name;
			$_slot[$key]->personal_upcoins = DB::table("tbl_pv_logs")->where("owner_slot_id",$slot->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount");
			$_slot[$key]->months_maintained = $this->get_months($slot->slot_id,$slot->permanent_rank_id)["months_maintained"];
		}
		
		$data["_slot"] = $_slot;

		if(Request::input('settings_for_global'))
		{
			DB::table('tbl_settings')->where('key','settings_for_global')->update(['value'=>Request::input('settings_for_global')]);
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." changed  the setting for starting global pool sharing to ".Request::input('settings_for_global').".");
			$data['settings_for_global'] = DB::table('tbl_settings')->where('key','settings_for_global')->first();
		}

		if(!$data['check'])
		{	
			DB::table('tbl_settings')->insert(['key'=>'global_enable','value'=>'0']);
			$data['check'] = DB::table('tbl_settings')->where('key','global_enable')->first();
		}
		
		if(Request::input('sleep'))
		{
			sleep(1);
			return Redirect::to('/admin/transaction/global_pool_sharing');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visit Global Pool Sharing.");
		}

		if(isset($_POST['sbmt']))
		{
			ignore_user_abort(true);
			set_time_limit(0);
			$strURL = "/admin/transaction/global_pool_sharing?sleep=1";
			header("Location: $strURL", true);
			header("Connection: close", true);
			header("Content-Encoding: none\r\n");
			header("Content-Length: 0", true);


			flush();
			ob_flush();

			session_write_close();
			DB::table('tbl_settings')->where('key','global_enable')->update(['value'=>1]);

			$this->shared_distribution();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." starts the Global Pool Sharing.");
			$last_date = DB::table('tbl_global_pv_done')->orderBy('global_pv_done_id','DESC')->first();
			if($last_date)
			{
				$insert['start_date'] = Tbl_pv_logs::where('date_created','>',$last_date->last_date)->orderBy('personal_pv_logs_id','ASC')->first();
				$insert['start_date'] = $insert['start_date']->date_created;
				$insert['last_date']  = Tbl_pv_logs::where('date_created','>',$last_date->last_date)->orderBy('personal_pv_logs_id','DESC')->first();
				$insert['last_date']  = $insert['last_date']->date_created;
				DB::table('tbl_global_pv_done')->insert($insert);			
			}
			else
			{
				if(Tbl_pv_logs::orderBy('personal_pv_logs_id','ASC')->first())
				{
					$insert['start_date'] = Tbl_pv_logs::orderBy('personal_pv_logs_id','ASC')->first();
					$insert['start_date'] = $insert['start_date']->date_created;
					$insert['last_date']  = Tbl_pv_logs::orderBy('personal_pv_logs_id','DESC')->first();
					$insert['last_date']  = $insert['last_date']->date_created;
					DB::table('tbl_global_pv_done')->insert($insert);	
				}
			}
			DB::table('tbl_settings')->where('key','global_enable')->update(['value'=>0]);
			DB::table("tbl_slot")->update(["removed_from_gps"=>0]);
			sleep(5);
			exit;
		}

        return view('admin.transaction.global_pool_sharing', $data);
	}

	public function shared_distribution()
	{
		$data['gps'] = DB::table('tbl_settings')->where('key','=','global_pv_sharing_percentage')->first()->value;
        $data['total_pv'] = $this->compute_gained_pv();
        $shared = ($data['gps']/100 )* $data['total_pv'];	
	
        $membership = Tbl_compensation_rank::where("compensation_rank_percentage","!=",0)->get();
        foreach($membership as $key => $m)
        {
        	$global_pool_sharing  = $m->compensation_rank_percentage;
        	$amount_to_shared = ($global_pool_sharing/100)*$shared;
        	$slot = Tbl_slot::where('permanent_rank_id',$m->compensation_rank_id)->where("removed_from_gps",0)->membership()->get();
        	$count = Tbl_slot::where('permanent_rank_id',$m->compensation_rank_id)->where("removed_from_gps",0)->count();
        	if($count != 0	)
        	{
	        	$divided_amount = $amount_to_shared / $count;
	    		if($divided_amount != 0)
	    		{
		        	foreach($slot as $keys => $s)
		        	{
			            /* INSERT LOG */
			            $log = "Your slot #".$s->slot_id." gain an amount of <b>".number_format($divided_amount,2)." wallet </b> you earned from Global Pool Sharing. (".$data['gps']."% of ".$data['total_pv']." equal to ".number_format($shared,2)." and shared to all ".$count." ".$m->membership_name.", ".number_format($divided_amount,2)." each).";
			            Log::slot($s->slot_id, $log, $divided_amount,"Global Pool Sharing",$s->slot_id);
		        	}	
	    		}
        	}
        }
	}

	public function compute_gained_pv()
	{
		$last_date = DB::table('tbl_global_pv_done')->orderBy('global_pv_done_id','DESC')->first();
		if($last_date)
		{	
			// return Tbl_transaction::where('created_at','>',$last_date->last_date)->sum('earned_pv');
			return Tbl_pv_logs::where("amount",">=",0)->where("date_created",'>',$last_date->last_date)->where("used_for_redeem",0)->sum("amount");
		}
		else
		{
			
			// return Tbl_transaction::sum('earned_pv');

			return Tbl_pv_logs::where("amount",">=",0)->where("used_for_redeem",0)->sum("amount");
		}
	}

	public function get_months($id,$rank_id)
	{
		$rank					= DB::table("tbl_compensation_rank")->where("compensation_rank_id",$rank_id)->first();
		$current_year   		= date("Y-", strtotime(Carbon::now()));
		$data["january"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."01")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."01")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["february"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."02")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."02")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["march"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."03")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."03")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["april"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."04")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."04")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["may"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."05")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."05")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["june"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."06")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."06")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["july"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."07")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."07")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["august"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."08")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."08")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["september"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."09")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."09")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["october"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."10")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."10")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["november"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."11")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."11")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["december"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."12")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."12")->where("used_for_redeem",0)->sum("amount") : 0;	
		$count_months           = 0;
		
		foreach($data as $d)
		{
			if($d >= $rank->required_personal_pv_maintenance)
			{
				$count_months++;
			}
		}
		
		
		$data["months_maintained"] = $count_months;
		
		return $data;
	}
	
	
	public function delete_gps($id)
	{
		DB::table("tbl_slot")->where("slot_id",$id)->update(["removed_from_gps"=>1]);
		
		return Redirect::to("admin/transaction/global_pool_sharing");
	}
	
	public function details($id)
	{
		$data["id"]				= $id;
		$current_year   		= date("Y-", strtotime(Carbon::now()));
		$data["january"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."01")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."01")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["february"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."02")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."02")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["march"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."03")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."03")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["april"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."04")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."04")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["may"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."05")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."05")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["june"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."06")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."06")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["july"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."07")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."07")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["august"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."08")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."08")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["september"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."09")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."09")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["october"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."10")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."10")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["november"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."11")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."11")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["december"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."12")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."12")->where("used_for_redeem",0)->sum("amount") : 0;	

		
		return view('admin.transaction.global_pool_sharing_month_reports', $data);
	}

}