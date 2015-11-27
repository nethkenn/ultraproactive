<?php namespace App\Http\Controllers;
use App\Tbl_slot;
use DB;
use Redirect;
use App\Tbl_distribution_history;
use App\Rel_distribution_history;
use App\Tbl_tree_placement;
use App\Tbl_tree_sponsor;
use Carbon\Carbon;
use Request;
use App\Classes\Compute; 
use App\Classes\Log;
use App\Tbl_wallet_logs;
use App\Classes\Admin;
use App\Tbl_unilevel_check_match;
class AdminUnilevelController extends AdminController
{

	public function indexs()
	{
		$data['slot'] = $this->get_data_passed();
		$data['last_update'] = Tbl_distribution_history::orderBy('distribution_id','DESC')->first();
		$data['history'] = Rel_distribution_history::get();
		$check = DB::table('tbl_settings')->where('key','check_match')->first();

		if(!$check)
		{	
			DB::table('tbl_settings')->insert(['key'=>'check_match','value'=>'0']);
			$check = DB::table('tbl_settings')->where('key','check_match')->first();
		}

		$data['check'] = $check;

		if(isset($_POST['sbmt']))
		{
			ignore_user_abort(true);
			set_time_limit(0);
			$strURL = "/admin/transaction/unilevel-distribution/dynamic?sleep=1";
			header("Location: $strURL", true);
			header("Connection: close", true);
			header("Content-Encoding: none\r\n");
			header("Content-Length: 0", true);


			flush();
			ob_flush();

			session_write_close();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." used the dynamic compression.");
			$this->dynamic();

			sleep(5);
			exit;
		}

		if(Request::input('sleep'))
		{
			sleep(1);
			return Redirect::to('admin/transaction/unilevel-distribution/dynamic');
		}
		else
		{	
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visit Dynamic Compression.");
		}

        return view('admin.transaction.unilevel_dynamic',$data);
	}


	public function dynamic()
	{		
		$check = DB::table('tbl_settings')->where('key','check_match')->first();
		DB::table('tbl_settings')->where('key','check_match')->update(['value'=>1]);
		$check_match = null;	
		if($check->value == 0)
		{
			$failed_slots = $this->get_data_failed();
			if($failed_slots)
			{
				foreach($failed_slots as $key => $f)
				{
					$ctr = 0;
					$placement = Tbl_tree_sponsor::child($f->slot_id)->orderby("sponsor_tree_level", "asc")->distinct_level()
																		->join('tbl_slot','tbl_slot.slot_id','=','tbl_tree_sponsor.sponsor_tree_parent_id')
																		->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
																		->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
																		->get();
					$gpv = $f->slot_group_points;
					/* COMPRESS */
					foreach($placement as $key => $tree)
					{
						$recipient = Tbl_slot::id($tree->sponsor_tree_parent_id)->membership()->first();
						$max_gpv   = $recipient->max_group_pv;
						$r_gpv 	   = $recipient->slot_group_points;
							if($max_gpv > $r_gpv)
							{
								$r_gpv = $r_gpv + $gpv;
								
								if($r_gpv >= $max_gpv)
								{
									$gpv = $r_gpv - $max_gpv;
									$r_gpv = $r_gpv - $gpv;
								}
								else
								{
									$gpv = 0;
								}
							}
						$update_recipient['slot_group_points'] = $r_gpv;
						Tbl_slot::id($tree->sponsor_tree_parent_id)->update($update_recipient);
							if($gpv == 0)
							{
								break;
							}
					}
					$update['slot_group_points'] = 0;
					Tbl_slot::id($f->slot_id)->update($update);
				}				
			}


			$slots = $this->get_data_passed();
			if($slots)
			{
				foreach($slots as $key => $slot)
				{
					$oneslot = Tbl_slot::account()->membership()->where('slot_id',$slot->slot_id)->first();
					/* UPDATE HIGHEST PV*/
					if($oneslot->slot_group_points > $oneslot->slot_highest_pv)
		            {
		                $update["slot_highest_pv"] = $oneslot->slot_group_points;
		            }
		            
		            /* GET SPONSOR LIST */
					$placement = Tbl_tree_sponsor::child($slot->slot_id)->level()->distinct_level()->get();

					/* GET GROUP PV AND CONVERT TO WALLET*/
					$gpv = $oneslot->slot_group_points * $oneslot->multiplier;

					/* UPDATE THE MONTH COUNT */
					$update['slot_maintained_month_count'] = $oneslot->slot_maintained_month_count + 1;
					Tbl_slot::where('slot_id',$slot->slot_id)->update($update);

					if($gpv != 0)
					{
						/* LOGS FOR WALLET */
						$log = "Your slot #".$slot->slot_id." met the requirement PV (".$oneslot->membership_required_pv.") and convert your ".$oneslot->slot_group_points."GPV to<b> ".number_format($gpv, 2)." wallet </b>"; 
			            Log::account($slot->slot_owner, $log);
			 			$log = "Your slot #".$slot->slot_id." met the requirement PV (".$oneslot->membership_required_pv.") and convert your ".$oneslot->slot_group_points."GPV to<b> ".number_format($gpv, 2)." wallet </b>";           
			            Log::slot($slot->slot_id,$log,$gpv,"Dynamic Compression",$slot->slot_id); 						
						
						if(isset($check_match[$slot->slot_id]))
						{
							$check_match[$slot->slot_id]= $check_match[$slot->slot_id] + $gpv;
						}
						else
						{
							$check_match[$slot->slot_id] = $gpv;
						}

					}

		 			/* CHECK IF PROMOTED */
					Compute::check_promotion_qualification($oneslot->slot_id);				
				}				
			}


			/* Distribute Bonus For Check Match */
			$this->distribute_check_match($check_match);

			/* Leadership Bonus */
			$this->leadership_bonus($check_match);

			/* UPDATE ALL SLOT TO ZERO GPV AND PV*/
			$updateall['slot_group_points'] = 0;
			$updateall['slot_personal_points'] = 0;
			Tbl_slot::account()->membership()->update($updateall);	
		}	
		DB::table('tbl_settings')->where('key','check_match')->update(['value'=>0]);
	}

	public function distribute_check_match($slots)
	{
		$unilevel_setting = DB::table('tbl_unilevel_check_match')->get();
		$unilevel = null;

		foreach($unilevel_setting as $key => $uni)
		{
			$unilevel[$uni->membership_id][$uni->level] = $uni->value;
		}
		if($slots)
		{
			foreach($slots as $key => $amount)
			{
				$oneslot = Tbl_slot::account()->membership()->where('slot_id',$key)->first();

	            /* GET SPONSOR LIST */
				$placement = Tbl_tree_sponsor::child($key)->level()->distinct_level()->get();

				/* UNILEVEL CHECK MATCH BONUS */
				foreach($placement as $keys => $tree)
				{
					$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->sponsor_tree_parent_id)->first();
					if(isset($unilevel[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
					{
						/* COMPUTE */
						$percentage = $unilevel[$slot_recipient->slot_membership][$tree->sponsor_tree_level];	
						$amt = ($unilevel[$slot_recipient->slot_membership][$tree->sponsor_tree_level]/100)*$amount;

						if($amt != 0)
						{
							/* PUT ON WALLET LOGS*/
							$log = "Your slot #".$slot_recipient->slot_id." earn<b> ".$amt." wallet </b> from <b>Unilevel Check Match Bonus</b> when slot #".$key." earned an amount of ".$amount." and convert its amount to ".$percentage."% as your wallet. (Current Membership: ".$slot_recipient->membership_name.", Sponsor level:".$tree->sponsor_tree_level.")";
			                Log::account($slot_recipient->slot_owner, $log);
			                Log::slot($slot_recipient->slot_id,$log,$amt,"Unilevel Check Match",$key); 							
						}
					}
				}
			}			
		}

	}

	public function leadership_bonus($slots)
	{

		if($slots)
		{
			$unilevel_setting = DB::table('tbl_unilevel_setting')->get();
			$unilevel = null;

			foreach($unilevel_setting as $key => $uni)
			{
				$unilevel[$uni->membership_id][$uni->level] = $uni->value;
			}

			$breakaway_bonus_setting = DB::table('tbl_unilevel_setting')->get();
			$breakaway = null;

			foreach($breakaway_bonus_setting as $key => $uni)
			{
				$breakaway[$uni->membership_id][$uni->level] = $uni->value;
			}

			foreach($slots as $key => $amount)
			{
				/* GET THE SlOT */
				$oneslot = Tbl_slot::account()->membership()->where('slot_id',$key)->first();

		        /* GET SPONSOR LIST */
				$placement = Tbl_tree_sponsor::child($oneslot->slot_id)->orderby("sponsor_tree_level", "asc")->distinct_level()->get();

				/* FOR BREAK STATEMENT */
				$ctr = 0;

				/* UNILEVEL CHECK MATCH BONUS */
				foreach($placement as $keys => $tree)
				{
						/* SLOT RECIPIENT */
						$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->sponsor_tree_parent_id)->first();
						
						/* CHECK PERCENTAGE */
						$percentage = $slot_recipient->leadership_bonus - $oneslot->leadership_bonus;

						/* GIVE A BONUS IF PERCENTAGE IS NOT 0*/
						if($percentage > 0)
						{
							$wallet = ($percentage/100)*$amount;
							$logs = "Your slot #".$slot_recipient->slot_id." earned <b>".number_format($wallet,2)." wallet</b>  from ".$percentage."% of Leadership Bonus(".$amount."). You earned it when slot #".$oneslot->slot_id." gain a ".$amount." wallet from Unilevel bonus.";
							Log::slot($slot_recipient->slot_id, $logs, $wallet,"Leadership Bonus",$oneslot->slot_id);
							$ctr++;
						}
						else
						{
							$this->breakaway_bonus($slot_recipient,$tree,$breakaway,$amount,$oneslot);
						}	

						/* STOP IF ALREADY GIVE A LEADERSHIP BONUS */
						if($ctr != 0)
						{
							break;
						}
				}				
			}	
		}
	}

	public function breakaway_bonus($slot,$tree,$breakaway,$bonus,$oneslot)
	{
            if(isset($breakaway[$slot->membership_id][$tree->sponsor_tree_level]))
            {
            	if($breakaway[$slot->membership_id][$tree->sponsor_tree_level] != 0)
            	{
	            	$amount = ($breakaway[$slot->membership_id][$tree->sponsor_tree_level]/100) * $bonus;
	            	$percentage = $breakaway[$slot->membership_id][$tree->sponsor_tree_level];

	            	if($amount != 0)
	            	{
						$logs = "Your slot #".$slot->slot_id." earned <b>".number_format($amount,2)." wallet</b>  from ".$percentage."% of Breakaway Bonus(".$bonus."). You earned it when slot #".$oneslot->slot_id." gain a ".$amount." wallet from Unilevel bonus.";
						Log::slot($slot->slot_id, $logs, $amount,"Breakaway Bonus",$oneslot->slot_id);
	            	}
            	}
            }
	}

	public function get_data_passed()
	{
		$slots = Tbl_slot::account()->membership()
						->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
						->get();
		if($slots->count() == 0)
		{
			$slots = null;
		}

		return $slots;		
	}

	public function get_data_failed()
	{
		$slots = Tbl_slot::account()->membership()
						->where('slot_personal_points', '<', DB::raw('membership_required_pv'))
						->where('slot_group_points','!=',0)
						->get();
		if($slots->count() == 0)
		{
			$slots = null;
		}
		return $slots;
	}
}

