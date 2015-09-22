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
use App\Tbl_unilevel_check_match;
class AdminUnilevelController extends AdminController
{

	public function indexs()
	{
		$data['slot'] = $this->get_data_view();
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

			$data = $this->dynamic();
			// return Redirect::to('admin/transaction/unilevel-distribution/dynamic');
			
			sleep(5);
			exit;
		}

		if(Request::input('sleep'))
		{
			sleep(1);
			return Redirect::to('admin/transaction/unilevel-distribution/dynamic');
		}

        return view('admin.transaction.unilevel_dynamic',$data);
	}


	public function dynamic()
	{	

		$check = DB::table('tbl_settings')->where('key','check_match')->first();
		/* CHECK IF IT STILL PROCESSING */
		if($check->value == 0)
		{
			DB::table('tbl_settings')->where('key','check_match')->update(['value'=>1]);
			$slots = $this->get_data();
			$unilevel_setting = DB::table('tbl_unilevel_setting')->get();
			$unilevel = null;
			$check_match_slot = null;

			/* SET THE UNILEVEL SETTING*/
			foreach($unilevel_setting as $key => $uni)
			{
				$unilevel[$uni->membership_id][$uni->level] = $uni->value;
			}

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

				/* PUT DATA FOR UNILEVEL CHECK MATCH */
				// if(isset($check_match_slot[$slot->slot_id]))
				// {
	 			//   $check_match_slot[$slot->slot_id] = $check_match_slot[$slot->slot_id] + $gpv;
				// }
				// else
				// {
				//   $check_match_slot[$slot->slot_id] = $gpv;
				// }

				/* UPDATE THE MONTH COUNT */
				$update['slot_maintained_month_count'] = $oneslot->slot_maintained_month_count + 1;
				Tbl_slot::where('slot_id',$slot->slot_id)->update($update);

				/* LOGS FOR WALLET */
				$log = "Your slot #".$slot->slot_id." met the requirement PV (".$oneslot->membership_required_pv.") and convert your ".$oneslot->slot_group_points."GPV to<b> ".number_format($gpv, 2)." wallet </b>"; 
	            Log::account($slot->slot_owner, $log);
	 			$log = "Your slot #".$slot->slot_id." met the requirement PV (".$oneslot->membership_required_pv.") and convert your ".$oneslot->slot_group_points."GPV to<b> ".number_format($gpv, 2)." wallet </b>";           
	            Log::slot($slot->slot_id,$log,$gpv,"Dynamic Compression",$slot->slot_id); 	

	 			/* CHECK IF PROMOTED */
				Compute::check_promotion_qualification($oneslot->slot_id);

				/* UNILEVEL BONUS */
				foreach($placement as $key => $tree)
				{
					$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->sponsor_tree_parent_id)->first();
					if(isset($unilevel[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
					{
						/* COMPUTE */
						$percentage = $unilevel[$slot_recipient->slot_membership][$tree->sponsor_tree_level];	
						$amt = ($unilevel[$slot_recipient->slot_membership][$tree->sponsor_tree_level]/100)*$gpv;
						if($amt != 0)
						{
							/* PUT ON WALLET LOGS*/
							$log = "Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($amt, 2) . " wallet</b> from ".$percentage."% of slot #".$slot->slot_id." GPV(".$gpv.") dynamic compression (Your current membership is ".$slot_recipient->membership_name." and your the sponsor level ".$tree->sponsor_tree_level." of slot #".$slot->slot_id.") ";
			                Log::account($slot_recipient->slot_owner, $log);
			                Log::slot($slot_recipient->slot_id,$log,$amt,"Dynamic Compression",$slot_recipient->slot_id); 	

							/* PUT DATA FOR UNILEVEL CHECK MATCH */
							if(isset($check_match_slot[$slot_recipient->slot_id]))
							{
				           	  $check_match_slot[$slot_recipient->slot_id] = $check_match_slot[$slot_recipient->slot_id] + $amt;
							}
							else
							{
							  $check_match_slot[$slot_recipient->slot_id] = $amt;
							}						
						}
					}
				}
			}

			/* PUT THE UNILEVEL CHECK DATA TO ANOTHER FUNCTION */
			$this->distribute_check_match($check_match_slot);

			/* UPDATE ALL SLOT TO ZERO GPV AND PV*/
			$updateall['slot_group_points'] = 0;
			$updateall['slot_personal_points'] = 0;
			Tbl_slot::account()->membership()->update($updateall);	

			/* PROCESS AVAILABLE */
			DB::table('tbl_settings')->where('key','check_match')->update(['value'=>0]);
		}

	}

	public function distribute_check_match($slots)
	{
		$unilevel_setting = DB::table('tbl_unilevel_check_match')->get();
		$unilevel = null;

		foreach($unilevel_setting as $key => $uni)
		{
			$unilevel[$uni->membership_id][$uni->level] = $uni->value;
		}

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


	public function get_data()
	{

			$slots = Tbl_slot::account()->membership()->where('slot_personal_points','>',0)->lists('slot_id');
			$sponsor_share = Tbl_tree_sponsor::whereIn('sponsor_tree_child_id',$slots)->level()->groupBy('sponsor_tree_parent_id')->lists('sponsor_tree_parent_id');
			$unilevel_setting = DB::table('tbl_unilevel_setting')->get();
			$unilevel = null;
			$slots = Tbl_slot::account()->membership()
										->whereIn('slot_id',$sponsor_share)
										->orWhereIn('slot_id',$slots)
										->get();
			$ctr = 0;	
			$return = null;		
			$check = DB::table('tbl_settings')->where('key','check_match')->first();


				foreach($unilevel_setting as $key => $uni)
				{
					$unilevel[$uni->membership_id][$uni->level] = $uni->value;
				}

				foreach($slots as $key => $slot)
				{
					$pv = 0;
					$oneslot = Tbl_slot::account()->membership()->where('slot_id',$slot->slot_id)->first();

					$pv = $pv + $oneslot->slot_personal_points;

					if($oneslot->slot_group_points > $oneslot->slot_highest_pv)
		            {
		                $update["slot_highest_pv"] = $oneslot->slot_group_points;
		                Tbl_slot::where('slot_id',$oneslot->slot_id)->update($update);
		            }

					$placement = Tbl_tree_sponsor::child($slot->slot_id)->level()->distinct_level()->get();
					$gpv = $oneslot->slot_group_points * $oneslot->multiplier;
					if($pv < $slot->membership_required_pv)
					{
						foreach($placement as $keys => $tree)
						{
							if($pv < $slot->membership_required_pv)
							{
								$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->sponsor_tree_parent_id)->first();
								if(isset($unilevel[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
								{
									$pv = $pv + $slot_recipient->slot_personal_points;				
								}
							}
						}
					}

					if($pv >= $slot->membership_required_pv)
					{
						$return[$ctr] = Tbl_slot::id($slot->slot_id)->account()->membership()->first();
						$return[$ctr]->gained_pv = $pv;
						$ctr++;
					}
				}				
				


			return $return;
	}

	public function get_data_view()
	{

			$slots = Tbl_slot::account()->membership()->where('slot_personal_points','>',0)->lists('slot_id');
			$sponsor_share = Tbl_tree_sponsor::whereIn('sponsor_tree_child_id',$slots)->level()->groupBy('sponsor_tree_parent_id')->lists('sponsor_tree_parent_id');
			$unilevel_setting = DB::table('tbl_unilevel_setting')->get();
			$unilevel = null;
			$slots = Tbl_slot::account()->membership()
										->whereIn('slot_id',$sponsor_share)
										->orWhereIn('slot_id',$slots)
										->get();
			$ctr = 0;	
			$return = null;		
			$check = DB::table('tbl_settings')->where('key','check_match')->first();

			if($check->value == 0)
			{
				foreach($unilevel_setting as $key => $uni)
				{
					$unilevel[$uni->membership_id][$uni->level] = $uni->value;
				}

				foreach($slots as $key => $slot)
				{
					$pv = 0;
					$oneslot = Tbl_slot::account()->membership()->where('slot_id',$slot->slot_id)->first();

					$pv = $pv + $oneslot->slot_personal_points;

					if($oneslot->slot_group_points > $oneslot->slot_highest_pv)
		            {
		                $update["slot_highest_pv"] = $oneslot->slot_group_points;
		                Tbl_slot::where('slot_id',$oneslot->slot_id)->update($update);
		            }

					$placement = Tbl_tree_sponsor::child($slot->slot_id)->level()->distinct_level()->get();
					$gpv = $oneslot->slot_group_points * $oneslot->multiplier;

					if($pv < $slot->membership_required_pv)
					{
						foreach($placement as $keys => $tree)
						{
							if($pv < $slot->membership_required_pv)
							{
								$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->sponsor_tree_parent_id)->first();
								if(isset($unilevel[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
								{
									$pv = $pv + $slot_recipient->slot_personal_points;				
								}
							}
						}						
					}

					if($pv >= $slot->membership_required_pv)
					{
						$return[$ctr] = Tbl_slot::id($slot->slot_id)->account()->membership()->first();
						$return[$ctr]->gained_pv = $pv;
						$ctr++;
					}
				}				
			}				


			return $return;
	}
}

