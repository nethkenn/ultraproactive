<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Compute;
use Crypt;
use App\Tbl_slot;
use App\Classes\Log;
use Carbon\Carbon;
use App\Classes\Admin;
use App\Tbl_tree_placement;
use App\Tbl_tree_sponsor;
use App\Tbl_binary_pairing;
use App\Tbl_indirect_setting;
use App\Tbl_unilevel_setting;
use App\Tbl_membership;
use App\Tbl_matching_bonus;
use App\Tbl_voucher;
use App\Tbl_wallet_logs;
use App\Tbl_travel_reward;
use Session;
use App\Tbl_travel_qualification;
use DateTime;
class AdminDevelopersController extends Controller
{
	// public function migration()
	// {
	// 	$id_code = 'ultratop';
	// 	//tbl_members , tbl_binary_points , tbl_binary_pairings , tbl_encashment, tbl_bonuses
	// 	$right = DB::table('tbl_binary_points')->select('points', DB::raw('SUM(points) as total_amount'))->where('id_code',$id_code)->where('position',"right")->first();
	// 	$left  = DB::table('tbl_binary_points')->select('points', DB::raw('SUM(points) as total_amount'))->where('id_code',$id_code)->where('position',"left")->first();
	// 	$minus = DB::table('tbl_binary_pairings')->select('points', DB::raw('SUM(points) as total_amount'))->where('username',$id_code)->first();
		
	// 	$right = $right->total_amount - $minus->total_amount;
	// 	$left  = $left->total_amount - $minus->total_amount;
		
	// 	$slot_wallet  = DB::table('tbl_bonuses')   ->select('amount', DB::raw('SUM(amount) as total_amount'))->where('recepient_code',$id_code)
	// 										       ->whereIn('bonus_type',['PAIR','DSI'])
	// 										       ->first();
 //        $slot_gc      = DB::table('tbl_bonuses')   ->select('amount', DB::raw('SUM(amount) as total_amount'))->where('recepient_code',$id_code)
	// 										       ->whereIn('bonus_type',['DGC','PGC'])
	// 										       ->first();
	// 	$minus_wallet = DB::table('tbl_encashment')->select('amount', DB::raw('SUM(amount) as total_amount'))->where('id_code',$id_code)
	// 										  	   ->first();
	// 	$minus_gc 	  = DB::table('tbl_encashment')->select('gc', DB::raw('SUM(gc) as total_amount'))->where('id_code',$id_code)
	// 										  	   ->first();

	// 	$slot_wallet  = $slot_wallet->total_amount - $minus_wallet->total_amount;

	// 	$slot_gc = $slot_gc->total_amount - $minus_gc->total_amount;

	// 	dd($right,$left,$slot_wallet,$slot_gc);
	// 	// Continue processing...



	// 	if(Request::input('migrate'))
	// 	{

	// 		DB::table('tbl_account')->delete();
	// 		DB::table('tbl_slot')->delete();

	// 		$get = DB::table('tbl_members')->where('tbpi_ctr','!=',1)->get();
	// 		foreach($get as $key => $g)
	// 		{



	// 	       	$password =   DB::table('tbl_members')->select((DB::raw("DECODE(password, 'yourtheboss2014') AS decoded")))
	// 		      									  ->selectRaw('password as encoded')
	// 											      ->where('tbpi_ctr', '=', $g->tbpi_ctr)->first();

	// 		    if($g->relationship == "NA" || $g->relationship == "-" || $g->relationship == "N/A" || $g->relationship == "n/a")
	// 		    {
	// 		    	$bene_id = null;
	// 		    	$beneficiary_id = null;
	// 		    }
	// 		    else
	// 		    {
	// 		    	$bene_id = DB::table('tbl_beneficiary_rel')->where('relation',$g->relationship)->first();
	// 		    	if(!$bene_id)
	// 		    	{
	// 		    		$bene_id = DB::table('tbl_beneficiary_rel')->where('relation',$g->relationship)->insertGetId(['relation'=>$g->relationship]);
	// 		    	}
	// 		    	else
	// 		    	{
	// 		    		$bene_id = $bene_id->beneficiary_rel_id;
	// 		    	}

	// 		    	$beneficiary_id = DB::table('tbl_beneficiary')->insertGetId(['whole_name'=>$g->beneficiary,'beneficiary_rel_id'=>$bene_id]);


	// 		    }



	// 			if($g->sex == "F")
	// 			{
	// 				$gender = "Female";
	// 			}								      
	// 			else
	// 			{
	// 				$gender = "Male";
	// 			}

	// 			if($g->address == "NA" || $g->address == "-" || $g->address == "N/A" || $g->address == "n/a")
	// 			{
	// 				$address = "";
	// 			}
	// 			else
	// 			{
	// 				$address = $g->address;
	// 			}

	// 			if($g->middlename == "NA" || $g->middlename == "N/A" || $g->middlename == "-" || $g->middlename == "n/a")
	// 			{
	// 				$fullname = $g->firstname." ".$g->lastname;
	// 			}
	// 			else
	// 			{
	// 				$fullname = $g->firstname." ".$g->middlename." ".$g->lastname;
	// 			}

	// 			if($g->landline == "NA" || $g->landline == "-" || $g->landline == "N/A" || $g->landline == "n/a")
	// 			{
	// 				$landline = "";
	// 			}
	// 			else
	// 			{
	// 				$landline = $g->landline;
	// 			}

	// 			if($g->mobile == "NA" || $g->mobile == "-" || $g->mobile == "N/A" || $g->landline == "n/a")
	// 			{
	// 				$mobile = "";
	// 			}
	// 			else
	// 			{
	// 				$mobile = $g->mobile;
	// 			}

	
	// 			$insert['account_name'] = $fullname;
	// 			$insert['account_email'] = $g->email;
	// 			$insert['account_username'] = $g->username;
	// 			$insert['account_contact_number'] = $mobile;
	// 			$insert['account_country_id'] = 
	// 			$insert['birthday'] = $g->birthdate;
	// 			$insert['telephone'] = $landline;
	// 			$insert['gender'] = $gender;
	// 			$insert['address'] = $address;
	// 			$insert['account_password'] = Crypt::encrypt($password);
	// 			$insert['custom_field_value'] = " ";
	// 			$insert['image'] = "";
	// 			$insert['account_created_from'] = "Old System";
	// 			$insert['archived'] = 0;
	// 			$insert['beneficiary_id'] = $beneficiary_id;
	// 			$insert['account_date_created'] = $g->date_registered;

	// 			$account_id = DB::table('tbl_account')->insertGetId($insert);

	// 			$insert = null;

	// 			$slot_wallet = 0;
	// 			$slot_gc = 0;

	// 			$oldwallet = DB::table('tbl_bonuses')->where('recepient_code',$g->username)->get();

	// 			/*DGC,DSI,PAIR,PGC*/

	// 			foreach($oldwallet as $old)
	// 			{
	// 				if($old->bonus_type == "DGC")
	// 				{
	// 					$slot_gc = $slot_gc + $old->amount;
	// 				}
	// 				elseif ($old->bonus_type == "PGC") 
	// 				{
	// 					$slot_gc = $slot_gc + $old->amount;
	// 				}
	// 				elseif ($old->bonus_type == "PAIR") 
	// 				{
	// 					$slot_wallet = $slot_wallet + $old->amount;
	// 				}
	// 				elseif ($old->bonus_type == "DSI") 
	// 				{
	// 					$slot_wallet = $slot_wallet + $old->amount;
	// 				}
	// 			} 


	// 			if($g->username=="ULTRATOP")
	// 			{
	// 				$insert['slot_owner'] = $account_id;
	// 				$insert['slot_membership'] = 1;
	// 				if($g->status_type == "PAID")
	// 				{
	// 					$slot_type = "PS";
	// 				}
	// 				else if($g->status_type == "FREE")
	// 				{
	// 					$slot_type = "FS";
	// 				}
	// 				else if($g->status_type == "CD")
	// 				{
	// 					$slot_type = "CD";
	// 				}
	// 				$insert["slot_type"] = $slot_type;
	// 				$insert["slot_rank"] = 1;
	// 				$insert["slot_sponsor"] = 999999999;
	// 				$insert["slot_placement"] = 999999999;
	// 				$insert["slot_position"] = "left";
	// 				$insert["slot_wallet"] = $slot_wallet;
	// 				$insert["slot_gc"] = $slot_gc;
	// 				DB::table('tbl_slot')->insert($insert);
	// 			}
	// 			else
	// 			{

	// 			}

	// 			$insert = null;
	// 		}
			

	// 	}

 //        return view('admin.developer.migration');
	// }
	// public function negativecd()
	// {
	// 	$get_cd = Tbl_slot::where('slot_type','CD')->get();

	// 	foreach($get_cd as $key => $slot)
	// 	{
	// 		$insert[$key]['wallet_amount'] = -3000;
	// 		$insert[$key]['keycode'] 	   = "CD Slot";     
	// 		$insert[$key]['slot_id']       = $slot->slot_id; 
	// 		$insert[$key]['cause_id']	   = $slot->slot_id;
	// 		$insert[$key]['account_id']    = $slot->slot_owner;
	// 		$insert[$key]['created_at']    = Carbon::now();
	// 		$insert[$key]['logs']   	   = "Negative CD Slot";
	// 		$insert[$key]['wallet_type']   = "Wallet";
	// 	}

	// 		DB::table('tbl_wallet_logs')->insert($insert);

	// 		dd("SUCCESS");
	// }

	// public function area_disable()
	// {
	// 	$rank = Admin::info()->admin_position_rank;

	// 	if($rank == 0)
	// 	{
			
	// 	}
	// 	else
	// 	{
	// 		return Redirect::to('/admin');
	// 	}


	// 	$rank = Admin::info()->admin_position_rank;
	// 	if($rank == 0)
	// 	{
			
	// 	}
	// 	else
	// 	{
	// 		return Redirect::to('/admin');
	// 	}

 //       $member_area = DB::table('tbl_settings')->where('key','disable_member_area')->first();
 //       if(!$member_area)
 //       {
 //           DB::table('tbl_settings')->insert(['key'=>'disable_member_area','value'=>'0']);
 //           $member_area = DB::table('tbl_settings')->where('key','disable_member_area')->first();
 //       }		

 //       if($member_area->value == 0)
 //       {
 //       	echo "Status: Member's area is enabled.";
	//         echo " <form method='get'>
	//                     <button type='submit' name='disable' value='Disable Member'>Disable Member</button>
	//               </form> ";

	//         if(Request::input('disable'))
	//         {
	//         	$member_area = DB::table('tbl_settings')->where('key','disable_member_area')->update(['value'=>1]);
	//         	return Redirect::to('admin/migration/disable');
	//         }
 //       }
 //       else
 //       {
 //       	echo "Status: Member's area is disabled.";
	//         echo " <form method='get'>
	//                     <button type='submit' name='disable' value='Enable Member'>Enable Member</button>
	//               </form> ";
 //  	        if(Request::input('disable'))
	//         {
	//         	$member_area = DB::table('tbl_settings')->where('key','disable_member_area')->update(['value'=>0]);
	//         	return Redirect::to('admin/migration/disable');
	//         }
 //       }


 //       $admin_area = DB::table('tbl_settings')->where('key','disable_admin_area')->first();
 //       if(!$admin_area)
 //       {
 //           DB::table('tbl_settings')->insert(['key'=>'disable_admin_area','value'=>'0']);
 //           $slot_owner_level = DB::table('tbl_settings')->where('key','disable_admin_area')->first();
 //       }		

 //       if($admin_area->value == 0)
 //       {
 //       	echo "Status: Admin's area is enabled.";
	//         echo " <form method='get'>
	//                     <button type='submit' name='disable_admin' value='Disable Admin'>Disable Admin</button>
	//               </form> ";

	//         if(Request::input('disable_admin'))
	//         {
	//         	$admin_area = DB::table('tbl_settings')->where('key','disable_admin_area')->update(['value'=>1]);
	//         	return Redirect::to('admin/migration/disable');
	//         }
 //       }
 //       else
 //       {
 //       	echo "Status: Admin's area is disabled.";
	//         echo " <form method='get'>
	//                     <button type='submit' name='disable_admin' value='Enable Admin'>Enable Admin</button>
	//               </form> ";
 //  	        if(Request::input('disable_admin'))
	//         {
	//         	$admin_area = DB::table('tbl_settings')->where('key','disable_admin_area')->update(['value'=>0]);
	//         	return Redirect::to('admin/migration/disable');
	//         }
 //       }
	// }

	public function re_entry()
	{

		$rank = Admin::info()->admin_position_rank;
		$data['entry'] = DB::table('tbl_re_entry')->get();
		$access_entry_level = DB::table('tbl_settings')->where('key','access_entry_level')->first();

		if($rank == 0)
		{
			
		}
		else
		{
			return Redirect::to('/admin');
		}
		if(Request::input('message'))
		{
			echo '<b>SUCCESS</b></br>';
		}
		if(Request::input('slot'))
		{
         	$data['info'] = Admin::info();
			$admin_id = $data['info']->account_id;
			$password = $data['info']->account_password;
			$password = Crypt::decrypt($password);

			if($password == Request::input('password'))
			{

			}
			else
			{
				die('Wrong password');	
			}


			$check = Tbl_slot::where('slot_id',Request::input('slot'))->first();

			if(Request::input('slot') == 1)
			{
				die("Can't use re entry for slot #1");
			}
			else
			{


				if($check)
				{

					if($check->slot_type != "CD")
					{
						dd("This slot is not a CD");
					}
					else
					{
						$owned_wallet = Tbl_wallet_logs::id(Request::input('slot'))->wallet()->sum('wallet_amount');

						$owned_wallet = -1 * $owned_wallet;
						$log = "Readjust wallet for CD to PS";
						Log::slot(Request::input('slot'), $log, $owned_wallet,'CD Slot',Request::input('slot'));
						Tbl_slot::where('slot_id',Request::input('slot'))->update(['slot_type'=>"PS"]);
					}


					$strURL = "/admin/developer/re_entry?message=Success";
					header("Location: $strURL", true);
					header("Location: $strURL", true);
					header("Connection: close", true);
					header("Content-Encoding: none\r\n");
					header("Content-Length: 0", true);


					flush();
					ob_flush();
					
					DB::table('tbl_re_entry')->insert(["slot_id"=>Request::input('slot'),'created_at'=>Carbon::now()]);
					Compute::entry(Request::input('slot'));

					$log = 'Slot #'.Request::input('slot').' was re-entry (CD to PS) by admin '.' by '.Admin::info()->account_name. '('.Admin::info()->admin_position_name.').';
					Log::Admin(Admin::info()->account_id,$log);

					session_write_close();
					sleep(5);
					exit;	
					// return Redirect::to('/admin/developer/entry?message=Success');
				}	
				else
				{
					die("Slot doesn't exist.");
				}

		
			}						
		}

        return view('admin.developer.for_entry',$data);












		// $audit = DB::table('tbl_admin_log')->where('created_at','LIKE','%2015-11%')->where('logs','LIKE','%delete Slot #%')->where('used',0)->get();
		// $container = null;
		// $ctr2 = 0;
		// foreach($audit as $data)
		// {
		// 	$unserialize = unserialize($data->old_data);

		// 	if($unserialize->slot_type == 'CD' || $unserialize->slot_type == 'FS')
		// 	{	
		// 			$slot_to_get = $unserialize->slot_placement;
		// 			$ctr = 0;
		// 			$condition = false;
		// 			while($condition == false)
		// 			{
		// 				$check_slot = Tbl_slot::id($slot_to_get)->first();
		// 				if($check_slot)
		// 				{
		// 					$condition = true;
		// 				}
		// 				else
		// 				{
		// 					foreach($audit as $data2)
		// 					{
		// 						$unserialize2 = unserialize($data2->old_data);
		// 						if($unserialize2->slot_id == $slot_to_get)
		// 						{
		// 							$slot_to_get = $unserialize2->slot_placement;
		// 							break;
		// 						}
		// 					}
		// 				}
		// 			}

  //                   $get_membership = DB::table('tbl_binary_pairing')->where('membership_id',$unserialize->slot_membership)->first();
	 //                $binary_l = $get_membership->pairing_point_l;
	 //                $binary_r = $get_membership->pairing_point_r;
	 //                $get = Tbl_tree_placement::where('placement_tree_child_id',$slot_to_get)->get();

	 //                $slot_info = Tbl_slot::id($slot_to_get)->first(); 
  //                   if(strtolower($unserialize->slot_position) == "left")
  //                   {
  //                       $update['slot_binary_left']  = $slot_info->slot_binary_left  + $binary_l;
  //                       Tbl_slot::id($slot_to_get)->update($update); 
  //                   }
  //                   elseif(strtolower($unserialize->slot_position) =="right")
  //                   {
  //                       $update['slot_binary_right'] = $slot_info->slot_binary_right + $binary_r; 
  //                       Tbl_slot::id($slot_to_get)->update($update);     
  //                   }
  //                   $this->re_check($slot_info->slot_id);
  //                   $update = null;

	 //                foreach($get as $g)
	 //                {
	 //                    $slot_info = Tbl_slot::id($g->placement_tree_parent_id)->first();   

	 //                    if($g->placement_tree_position == "left")
	 //                    {
	 //                        $update['slot_binary_left']  = $slot_info->slot_binary_left  + $binary_l;
	 //                        Tbl_slot::id($g->placement_tree_parent_id)->update($update); 	            
	 //                    }
	 //                    elseif($g->placement_tree_position =="right")
	 //                    {
	 //                        $update['slot_binary_right'] = $slot_info->slot_binary_right + $binary_r; 
	 //                        Tbl_slot::id($g->placement_tree_parent_id)->update($update);  
	 //                    }
	 //                    $this->re_check($slot_info->slot_id);
	 //                    $update = null; 
	 //                }            

		// 	}

		// 	DB::table('tbl_admin_log')->where('admin_log_id',$data->admin_log_id)->update(['used'=>1]);
		// }
		// dd('finish');
	}

	// public function re_check($slot_id)
	// {
	// 	    $_pairing = Tbl_binary_pairing::orderBy("pairing_point_l", "desc")->get();
	// 		$slot_recipient = Tbl_slot::id($slot_id)->membership()->first();
	// 		$method = "SLOT CREATION";
 //           /* RETRIEVE LEFT & RIGHT POINTS */
 //           $binary["left"] = $slot_recipient->slot_binary_left;
 //           $binary["right"] = $slot_recipient->slot_binary_right; 

 //           /* CHECK PAIRING */
 //           foreach($_pairing as $pairing)
 //           {   
 //               if($pairing->membership_id == $slot_recipient->slot_membership)
 //               {
 //                       while($binary["left"] >= $pairing->pairing_point_l && $binary["right"] >= $pairing->pairing_point_r)
 //                       {
 //                                   $binary["left"] = $binary["left"] - $pairing->pairing_point_l;
 //                                   $binary["right"] = $binary["right"] - $pairing->pairing_point_r;
                                    
 //                                   /* GET PAIRING BONUS */
 //                                   $pairing_bonus = $pairing->pairing_income;

 //                                   /* CHECK IF PAIRING BONUS IS ZERO */
 //                                   if($pairing_bonus != 0)
 //                                   {

 //                                       /* Check if entry per day is exceeded already */
 //                                       $count =  Tbl_slot::id($slot_id)->first();
 //                                       $member = Tbl_membership::where('membership_id',$slot_recipient->slot_membership)->first();
 //                                       $count = $count->pairs_today;
 //                                       $date = Carbon::now()->toDateString(); 
 //                                       $condition = null;
 //                                       $gc = false;


 //                                       /* Do this when date is new */
 //                                       $update['pairs_per_day_date'] = $date;
 //                                       $count = 1;
 //                                       $update['pairs_today'] = $count;
 //                                       $condition = true;

	//                                         if($slot_recipient->every_gc_pair != 0)
	//                                         {
	//                                             /* CHECK IF GC */
	//                                             if($count%$slot_recipient->every_gc_pair == 0)
	//                                             {
	//                                                 $gc = true;
	//                                             }                                                        
	//                                         }

 //                                       	/* Insert Count */
 //                                       	Tbl_slot::where('slot_id',$slot_recipient->slot_id)->update($update);

 //                                           $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($pairing_bonus, 2) . " wallet</b> from <b>MATCHING BONUS</b> due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right.";
	// 										if($gc == false)
	// 										{
	// 										     Compute::income_per_day($slot_recipient->slot_id,$pairing_bonus,'binary',$slot_recipient->slot_owner,$log,$slot_recipient->slot_id); 
	// 										}
	// 										elseif($gc == true)
	// 										{
	// 										    $gcbonus = $pairing_bonus;
	// 										    // Tbl_slot::where('slot_id',$slot_recipient->slot_id)->update(["slot_gc"=>$gcbonus]);
	// 										    $log = $log = "This is your ".$slot_recipient->every_gc_pair." MSB, Your ".$pairing_bonus." Income converted to GC (SLOT #".$slot_recipient->slot_id.") due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right.";
	// 										    Log::slot($slot_recipient->slot_id, $log, $gcbonus,"binary",$slot_recipient->slot_id,1);
	// 										    // Log::account($slot_recipient->slot_owner, $log);
	// 										} 

	// 										/* MATCHING SALE BONUS */
	// 										Compute::matching($slot_recipient->slot_id, $method, $slot_recipient, $pairing_bonus);  
 //                                   }                                                      
 //                       }                                
      
 //               }
 //           } 

 //   	/* UPDATE POINTS */
	// 	$update_recipient["slot_binary_left"] = $binary["left"];
	// 	$update_recipient["slot_binary_right"] = $binary["right"];
	// 	Tbl_slot::id($slot_id)->update($update_recipient);
	// 	$update_recipient = null;
	// }
	
	public function re_adjust_cd()
	{

		$rank = Admin::info()->admin_position_rank;
		$data['entry'] = DB::table('tbl_re_entry')->get();
		$access_entry_level = DB::table('tbl_settings')->where('key','access_entry_level')->first();

		if($rank == 0)
		{
			
		}
		else
		{
			return Redirect::to('/admin');
		}
		
		if(Request::input('message'))
		{
			echo '<b>SUCCESS</b></br>';
		}
		
		
		if(Request::input('amount'))
		{
         	$data['info'] = Admin::info();
			$admin_id = $data['info']->account_id;
			$password = $data['info']->account_password;
			$password = Crypt::decrypt($password);

			if($password == Request::input('password'))
			{
				$strURL = "/admin/developer/re_adjust_cd?message=Success";
				header("Location: $strURL", true);
				header("Location: $strURL", true);
				header("Connection: close", true);
				header("Content-Encoding: none\r\n");
				header("Content-Length: 0", true);
	
	
				flush();
				ob_flush();
				
					$get = Tbl_slot::where("slot_type","CD")->get();
					
					foreach($get as $g)
					{
						$amount = -1 * Request::input("amount");
						$log    = "CD Adjustment (Additional: ".number_format($amount).")";
						Log::slot($g->slot_id, $log, $amount,"CD Adjustment",$g->slot_id);
					}
	
				session_write_close();
				sleep(5);
				exit;
			}
			else
			{
				die('Wrong password');	
			}
		}

        return view('admin.developer.for_cd_adjust',$data);
	}
}

       