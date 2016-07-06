<?php namespace App\Classes;
use App\Tbl_slot;
use App\Tbl_tree_placement;
use App\Tbl_tree_sponsor;
use App\Tbl_binary_pairing;
use App\Tbl_indirect_setting;
use App\Tbl_unilevel_setting;
use App\Tbl_membership;
use App\Classes\Log;
use Carbon\Carbon;
use App\Tbl_matching_bonus;
use DB;
use App\Tbl_voucher;
use App\Tbl_wallet_logs;
use App\Tbl_travel_reward;
use Session;
use App\Tbl_travel_qualification;
use DateTime;
class Compute
{
    public static function tree($new_slot_id)
    {
    	$slot_info = Tbl_slot::id($new_slot_id)->first();
    	Compute::insert_tree_placement($slot_info, $new_slot_id, 1); /* TREE RECORD FOR BINARY GENEALOGY */
    	Compute::insert_tree_sponsor($slot_info, $new_slot_id, 1); /* TREE RECORD FOR SPONSORSHIP GENEALOGY */
    }
    public static function entry($new_slot_id, $method = "SLOT CREATION")
    {
        Compute::binary($new_slot_id, $method);
        Compute::direct($new_slot_id, $method);
        Compute::indirect($new_slot_id, $method);
    }
    public static function repurchase($buyer_slot_id, $binary_pts, $unilevel_pts,$upgrade_pts ,$method = "REPURCHASE")
    {
        Compute::unilevel_repurchase($buyer_slot_id, $unilevel_pts, $method, $upgrade_pts);
        Compute::binary_repurchase($buyer_slot_id, $binary_pts, $method);
    }
    public static function unilevel_repurchase($buyer_slot_id, $unilevel_pts, $method, $upgrade_pts)
    {
        $buyer_slot_info = Tbl_slot::id($buyer_slot_id)->account()->membership()->first();

        /* ----- COMPUTATION OF PERSONAL PV */
        $update_recipient["slot_personal_points"] = $buyer_slot_info->slot_personal_points + $unilevel_pts;

        /* INSERT LOG */
        $log = "Your slot #" . $buyer_slot_info->slot_id . " earned <b>" . number_format($unilevel_pts, 2) . " personal pv</b>.";
        Log::slot($buyer_slot_info->slot_id, $log, 0,$method,$buyer_slot_id);

        /* UPDATE SLOT CHANGES TO DATABASE */
        Tbl_slot::id($buyer_slot_info->slot_id)->update($update_recipient);
        $update_recipient = null;

        /* ----- COMPUTATION OF GROUP PV ----- */
        $_unilevel_setting = Tbl_unilevel_setting::get();
        $_tree = Tbl_tree_sponsor::child($buyer_slot_id)->level()->distinct_level()->get();

        /* RECORD ALL INTO A SINGLE VARIABLE */
        $unilevel_level = null;
        foreach($_unilevel_setting as $key => $level)
        {
            $unilevel_level[$level->membership_id][$level->level] =  $level->value;
        }

            /* CHECK IF LEVEL EXISTS */
            if($unilevel_level)
            {
                foreach($_tree as $key => $tree)
                {
                    /* GET SLOT INFO FROM DATABASE */
                    $slot_recipient = Tbl_slot::id($tree->sponsor_tree_parent_id)->membership()->first();
                    $update_recipient["slot_group_points"] = $slot_recipient->slot_group_points;
                    $update_recipient["slot_upgrade_points"] = $slot_recipient->slot_upgrade_points;

                    /* COMPUTE FOR BONUS */
                    if(isset($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
                    {
                        $unilevel_bonus = ($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]/100) * $unilevel_pts;  
                        $upgrade_bonus = ($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]/100) * $upgrade_pts;     
                    }
                    else
                    {
                        $unilevel_bonus = 0;
                        $upgrade_bonus = 0;
                    }
                    
                    /* CHECK IF BONUS IS ZERO */
                    if($unilevel_bonus != 0 || $upgrade_bonus != 0)
                    {
                        /* UPDATE WALLET */
                        $update_recipient["slot_group_points"] = $update_recipient["slot_group_points"] + $unilevel_bonus;
                        $update_recipient["slot_upgrade_points"] = $update_recipient["slot_upgrade_points"] + $upgrade_bonus;
                        
                        // if($update_recipient["slot_group_points"] > $slot_recipient->slot_highest_pv)
                        // {
                        //     $update_recipient["slot_highest_pv"] = $update_recipient["slot_group_points"];
                        // }

                        /* INSERT LOG */
                        $log = "Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($unilevel_bonus, 2) . " group pv and ". $upgrade_bonus ." promotion points</b>. You earned it when slot #" . $buyer_slot_id . " uses a code worth " . number_format($unilevel_pts, 2) . " PV. That slot is located on the Level " . $tree->sponsor_tree_level . " of your sponsor genealogy. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP.";
                        // Log::account($slot_recipient->slot_owner, $log);
                        Log::slot($slot_recipient->slot_id, $log, 0,$method,$buyer_slot_id);
                        /* UPDATE SLOT CHANGES TO DATABASE */
                        Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);

                        /* CHECK IF QUALIFIED FOR PROMOTION */
                        // Compute::check_promotion_qualification($slot_recipient->slot_id);
                    }
                }
            }            

    }

    public static function binary_repurchase($buyer_slot_id, $binary_pts, $method)
    {
        $new_slot_info = Tbl_slot::id($buyer_slot_id)->account()->membership()->first();
        $_pairing = Tbl_binary_pairing::orderBy("pairing_point_l", "desc")->where('membership_id',$new_slot_info->slot_membership)->get();

        /* GET SETTINGS */
        $required_pairing_points = 100;

        /* GET THE TREE */
        $_tree = Tbl_tree_placement::child($buyer_slot_id)->level()->distinct_level()->get();
        

                /* UPDATE BINARY POINTS */
                foreach($_tree as $tree)
                {
                    /* GET SLOT INFO FROM DATABASE */
                    $slot_recipient = Tbl_slot::id($tree->placement_tree_parent_id)->membership()->first();
                    // $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
                    // $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

                    /* RETRIEVE LEFT & RIGHT POINTS */
                    $binary["left"] = $slot_recipient->slot_binary_left;
                    $binary["right"] = $slot_recipient->slot_binary_right; 
                    $flushpoints = $slot_recipient->pair_flush_out_wallet;
                    /* ADD NECESARRY POINTS */
                    $earned_points = $binary_pts;

                    /* CHECK POINTS EARNED */
                    if($earned_points != 0)
                    {
                        $binary[$tree->placement_tree_position] = $binary[$tree->placement_tree_position] + $earned_points; 
                        
                        /* INSERT LOG FOR EARNED POINTS IN ACCOUNT */
                        $log = "Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($earned_points, 2) . " match points</b> on " . $tree->placement_tree_position . " when " . $new_slot_info->account_name . " used one if his/her product code.";
                        Log::slot($slot_recipient->slot_id, $log, 0,$method,$buyer_slot_id);
                        // Log::account($slot_recipient->slot_owner, $log);

                        /* CHECK PAIRING */
                        foreach($_pairing as $pairing)
                        {
                            if($pairing->membership_id == $slot_recipient->slot_membership)
                            {
                                while($binary["left"] >= $pairing->pairing_point_l && $binary["right"] >= $pairing->pairing_point_r)
                                {
                                    $binary["left"] = $binary["left"] - $pairing->pairing_point_l;
                                    $binary["right"] = $binary["right"] - $pairing->pairing_point_r;

                                    /* GET PAIRING BONUS */
                                    $pairing_bonus = $pairing->pairing_income;

                                    /* CHECK IF PAIRING BONUS IS ZERO */
                                    if($pairing_bonus != 0)
                                    {

                                                /* Check if entry per day is exceeded already */
                                                $count =  Tbl_slot::id($slot_recipient->slot_id)->first();
                                                $member = Tbl_membership::where('membership_id',$slot_recipient->slot_membership)->first();
                                                $count = $count->pairs_today;
                                                $date = Carbon::now()->toDateString(); 
                                                $condition = null;
                                                $gc = false;
                                                $slot_recipient_gc = Tbl_slot::id($tree->placement_tree_parent_id)->membership()->first();
                                                /* Check if date is equal today's date*/
                                                if($slot_recipient_gc->pairs_per_day_date == $date)
                                                {
                                                    if($member->max_pairs_per_day <= $count)
                                                    {
                                                        /* Already exceeded */
                                                        $update['pairs_today'] = $count;
                                                        $condition = false;
                                                    }
                                                    else
                                                    {
                                                        /* Go Ahead */
                                                        $count = $count + 1;
                                                        $update['pairs_today'] = $count;
                                                        $condition = true;

                                                        if($slot_recipient_gc->every_gc_pair != 0)
                                                        {
                                                            if($count%$slot_recipient_gc->every_gc_pair == 0)
                                                            {
                                                                $gc = true;
                                                            }                                                        
                                                        }

                                                    }
                                                }
                                                else
                                                {
                                                    /* Do this when date is new */
                                                    $update['pairs_per_day_date'] = $date;
                                                    $count = 1;
                                                    $update['pairs_today'] = $count;
                                                    $condition = true;

                                                    //IF GC EVERY PAIR IS IS NOT EQuAL TO 0  
                                                    if($slot_recipient_gc->every_gc_pair != 0)
                                                    {
                                                        /* CHECK IF GC */
                                                        if($count%$slot_recipient_gc->every_gc_pair == 0)
                                                        {
                                                            $gc = true;
                                                        }                                                        
                                                    }

                                                }
                                                $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
                                                if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                                                {                                        
                                                    /* Insert Count */
                                                    Tbl_slot::where('slot_id',$slot_recipient_gc->slot_id)->update($update);
                                                }

                                                /* Proceed when entry is okay */
                                                if($condition == true)
                                                {
                                                        /* UPDATE WALLET */
                                                        // $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $pairing_bonus;
                                                        // $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $pairing_bonus;
                                                        $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($pairing_bonus, 2) . " wallet</b> from <b>MATCHING BONUS</b> due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right. This combination was caused by a repurchase of one of your downlines."; 
                                                        /* CHECK IF NOT FREE SLOT */
                                                        $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');

                                                            //CHECK IF CONVERT TO GC OR NOT
                                                            if($gc == false)
                                                            {
                                                                Compute::income_per_day($slot_recipient->slot_id,$pairing_bonus,'binary_repurchase',$slot_recipient->slot_owner,$log,$buyer_slot_id);
                                                            }
                                                            elseif($gc == true)
                                                            {
                                                                $gcbonus = $pairing_bonus;
                                                                // Tbl_slot::where('slot_id',$slot_recipient->slot_id)->update(["slot_gc"=>$gcbonus]);

                                                                $log = "This is your ".$slot_recipient->every_gc_pair." MSB, Your ".$pairing_bonus." Income converted to GC (SLOT #".$slot_recipient->slot_id.") due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right. This combination was caused by a repurchase of one of your downlines.";
                                                                Log::slot($slot_recipient->slot_id, $log, $gcbonus,"binary_repurchase",$buyer_slot_id,1);
                                                                // Log::account($slot_recipient->slot_owner, $log);
                                                            }     
                                                            
                                                            if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                                                            {
                                                                  /* MATCHING SALE BONUS */
                                                                  Compute::matching($buyer_slot_id, "REPURCHASE", $slot_recipient, $pairing_bonus);                                           
                                                            }  


                                                        /* INSERT LOG */
                                                        // Log::account($slot_recipient->slot_owner, $log);
                                                        // Log::slot($slot_recipient->slot_id, $log, $pairing_bonus, "BINARY PAIRING");


                                                }
                                                else
                                                {   
                                                        $binary["left"]   = 0;
                                                        $binary["right"]  = 0;          
                                                        $make_it_zero["slot_binary_left"]  = $binary["left"];
                                                        $make_it_zero["slot_binary_right"] = $binary["right"];
                                                        Tbl_slot::id($tree->placement_tree_parent_id)->update($make_it_zero);
                                                        $log = "Im sorry! Max matching per day already exceed your slot #" . $slot_recipient->slot_id . " flushed out <b>" . number_format($pairing_bonus, 2) . " wallet</b> from <b>MATCHING BONUS</b> due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right. This combination was caused by a repurchase of one of your downlines.";          
                                                        // Log::account($slot_recipient->slot_owner, $log);
                                                        Log::slot($slot_recipient->slot_id, $log, 0,$method,$buyer_slot_id);
                                                        $flushpoints =  $flushpoints+$pairing_bonus;
                                                }
                                    }
                                }
                            }
                        } 

                        /* UPDATE POINTS */
                        $update_recipient["slot_binary_left"] = $binary["left"];
                        $update_recipient["slot_binary_right"] = $binary["right"];
                        $update_recipient["pair_flush_out_wallet"] = $flushpoints;
                        $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
                        /* CHECK IF NOT FREE SLOT */
                        Tbl_slot::id($tree->placement_tree_parent_id)->update($update_recipient);                           

                        /* UPDATE SLOT CHANGES TO DATABASE */

                        $update_recipient = null;
                    }
                }            
    }

    public static function check_promotion_qualification($slot_id)
    {
        $slot_info = Tbl_slot::membership()->id($slot_id)->first();

        if($slot_info->slot_group_points > $slot_info->slot_highest_pv)
        {
            $checkupdate["slot_highest_pv"] = $slot_info->slot_group_points;
            Tbl_slot::id($slot_id)->update($checkupdate);
        }

        $slot_info = Tbl_slot::membership()->id($slot_id)->first();
        $count = Tbl_tree_sponsor::where('sponsor_tree_parent_id',$slot_id)->where('sponsor_tree_level',1)->count();


            $data["next_membership"] = Tbl_membership::where("membership_required_pv_sales", ">",  $slot_info->membership_required_pv_sales)->orderBy("membership_required_pv_sales", "asc")->first();

            if($data["next_membership"])
            {
                $d = $data["next_membership"];
                if($d->membership_required_unilevel_leg == 0)
                {
                    if($d->membership_required_pv_sales != 0)
                    {   
                        if($count >= $d->membership_required_direct && $slot_info->slot_highest_pv >= $d->membership_required_pv_sales && $slot_info->slot_maintained_month_count >= $d->membership_required_month_count)
                        {
                            $update_slot["slot_upgrade_points"] = 0;
                            $update_slot["slot_membership"] = $data["next_membership"]->membership_id;
                            $update_slot["slot_highest_pv"] = 0;

                            $log = "Congratulation! Slot #" . $slot_id . " has been promoted from " . $slot_info->membership_name . " to " . $data["next_membership"]->membership_name;
                            Tbl_slot::id($slot_id)->update($update_slot);

                            Log::slot($slot_id, $log, 0,"Promoted",$slot_id);

                            // Log::account($slot_info->slot_owner, $log);                  
                        }                    
                    }
                }
                else
                {

                    if($d->membership_required_pv_sales != 0)
                    {   
                        if($slot_info->slot_highest_pv >= $d->membership_required_pv_sales && $slot_info->slot_maintained_month_count >= $d->membership_required_month_count)
                        {
                            $promote = false;
                            $get_direct = Tbl_tree_sponsor::where('sponsor_tree_parent_id',$slot_id)->where('sponsor_tree_level',1)->get();
                            $count_direct = 0;
                            foreach($get_direct as $g)
                            {
                                $check = Tbl_tree_sponsor::where('tbl_sponsor_tree',$g->tbl_sponsor_tree)->join('tbl_slot','tbl_tree_sponsor.sponsor_tree_child_id','=','tbl_slot.slot_id')->where('slot_membership','=',$d->membership_unilevel_leg_id)->where('sponsor_tree_level',1)->first();
                                $count = Tbl_tree_sponsor::where('sponsor_tree_parent_id',$g->sponsor_tree_child_id)->join('tbl_slot','tbl_tree_sponsor.sponsor_tree_child_id','=','tbl_slot.slot_id')->where('slot_membership','=',$d->membership_unilevel_leg_id)->count();
                            
                                if($check || $count > 0)
                                {
                                    $count_direct++;
                                }
                            }
                            if($count_direct >=  $d->membership_required_direct)
                            {
                                    $update_slot["slot_upgrade_points"] = 0;
                                    $update_slot["slot_membership"] = $data["next_membership"]->membership_id;
                                    $update_slot["slot_highest_pv"] = 0;

                                    $log = "Congratulation! Slot #" . $slot_id . " has been promoted from " . $slot_info->membership_name . " to " . $data["next_membership"]->membership_name;
                                    Tbl_slot::id($slot_id)->update($update_slot);

                                    Log::slot($slot_id, $log, 0,"Promoted",$slot_id);
                            }
                        }                    
                    }
                }
            }
    }

    public static function insert_tree_placement($slot_info, $new_slot_id, $level)
    {
    	$upline_info = Tbl_slot::id($slot_info->slot_placement)->first();

        if($upline_info)
        {
            $insert["placement_tree_parent_id"] = $upline_info->slot_id;
            $insert["placement_tree_child_id"] = $new_slot_id;
            $insert["placement_tree_position"] = $slot_info->slot_position;
            $insert["placement_tree_level"] = $level;
            Tbl_tree_placement::insert($insert);
            $level++;
            Compute::insert_tree_placement($upline_info, $new_slot_id, $level);  
        }   
    }

    public static function insert_tree_sponsor($slot_info, $new_slot_id, $level)
    {
    	$upline_info = Tbl_slot::id($slot_info->slot_sponsor)->first();

        if($upline_info)
        {
            $insert["sponsor_tree_parent_id"] = $upline_info->slot_id;
            $insert["sponsor_tree_child_id"] = $new_slot_id;
            $insert["sponsor_tree_level"] = $level;
            Tbl_tree_sponsor::insert($insert);
            $level++;
            Compute::insert_tree_sponsor($upline_info, $new_slot_id, $level);  
        }
    }

    public static function binary($new_slot_id, $method = "SLOT CREATION")
    {
        $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();
        $_pairing = Tbl_binary_pairing::orderBy("pairing_point_l", "desc")->get();
        
    	/* GET SETTINGS */
    	$required_pairing_points = 100;

    	/* GET THE TREE */
    	$_tree = Tbl_tree_placement::child($new_slot_id)->level()->distinct_level()->get();

            /* UPDATE BINARY POINTS */
            foreach($_tree as $tree)
            {
                /* GET SLOT INFO FROM DATABASE */
                $slot_recipient = Tbl_slot::id($tree->placement_tree_parent_id)->membership()->first();
                // $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
                // $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

                /* RETRIEVE LEFT & RIGHT POINTS */
                $binary["left"] = $slot_recipient->slot_binary_left;
                $binary["right"] = $slot_recipient->slot_binary_right; 
                $flushpoints = $slot_recipient->pair_flush_out_wallet;
                /* ADD NECESARRY POINTS */
                $earned_points = $new_slot_info->membership_binary_points;

                /* CHECK POINTS EARNED */
                if($earned_points != 0)
                {
                    $binary[$tree->placement_tree_position] = $binary[$tree->placement_tree_position] + $earned_points; 
                    $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
                    if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                    {
                        /* INSERT LOG FOR EARNED POINTS IN ACCOUNT */
                        $log = "Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($earned_points, 2) . " match points</b> on " . $tree->placement_tree_position . " when " . $new_slot_info->account_name . " with " . $new_slot_info->membership_name . " MEMBERSHIP created a new slot (#" . $new_slot_info->slot_id . ").";
                        Log::slot($slot_recipient->slot_id, $log, 0,"Binary Earn",$new_slot_info->slot_id);
                        // Log::account($slot_recipient->slot_owner, $log);                       
                    }


                    /* CHECK PAIRING */
                    foreach($_pairing as $pairing)
                    {   
                        if($pairing->membership_id == $slot_recipient->slot_membership)
                        {
                                while($binary["left"] >= $pairing->pairing_point_l && $binary["right"] >= $pairing->pairing_point_r)
                                {
                                            $binary["left"] = $binary["left"] - $pairing->pairing_point_l;
                                            $binary["right"] = $binary["right"] - $pairing->pairing_point_r;
                                            
                                            /* GET PAIRING BONUS */
                                            $pairing_bonus = $pairing->pairing_income;

                                            /* CHECK IF PAIRING BONUS IS ZERO */
                                            if($pairing_bonus != 0)
                                            {

                                                /* Check if entry per day is exceeded already */
                                                $count =  Tbl_slot::id($tree->placement_tree_parent_id)->first();
                                                $member = Tbl_membership::where('membership_id',$slot_recipient->slot_membership)->first();
                                                $count = $count->pairs_today;
                                                $date = Carbon::now()->toDateString();
                                                $condition = null;
                                                $gc = false;
                                                $slot_recipient_gc = Tbl_slot::id($tree->placement_tree_parent_id)->membership()->first();
                                                  /* Check if date is equal today's date*/
                                                if($slot_recipient_gc->pairs_per_day_date == $date)
                                                {
                                                    if($member->max_pairs_per_day <= $count)
                                                    {
                                                        /* Already exceeded */
                                                        $update['pairs_today'] = $count;
                                                        $condition = false;
                                                    }
                                                    else
                                                    {
                                                        /* Go Ahead */
                                                        $count = $count + 1;
                                                        $update['pairs_today'] = $count;
                                                        $condition = true;

                                                        if($slot_recipient_gc->every_gc_pair != 0)
                                                        {
                                                            /* CHECK IF GC */
                                                            if($count%$slot_recipient_gc->every_gc_pair == 0)
                                                            {
                                                                $gc = true;
                                                            }                                                        
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    /* Do this when date is new */
                                                    $update['pairs_per_day_date'] = $date;
                                                    $count = 1;
                                                    $update['pairs_today'] = $count;
                                                    $condition = true;

                                                    if($slot_recipient_gc->every_gc_pair != 0)
                                                    {
                                                        /* CHECK IF GC */
                                                        if($count%$slot_recipient_gc->every_gc_pair == 0 && $count != 0)
                                                        {
                                                            $gc = true;
                                                        }                                                        
                                                    }
                                                }
                                                $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
                                                if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                                                {  
                                                    /* Insert Count */
                                                    Tbl_slot::where('slot_id',$slot_recipient_gc->slot_id)->update($update);
                                                }

                                                /* Proceed when entry is okay */
                                                if($condition == true)
                                                {
                                                    /* UPDATE WALLET */
                                                    // $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $pairing_bonus;
                                                    // $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $pairing_bonus;

                                                    /* INSERT LOG */
                                                    $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($pairing_bonus, 2) . " wallet</b> from <b>MATCHING BONUS</b> due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right.";
                                                    // Log::account($slot_recipient->slot_owner, $log);
                                                    // Log::slot($slot_recipient->slot_id, $log, $pairing_bonus, "BINARY PAIRING");
                                                    $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
                                                            if($gc == false && $new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                                                            {
                                                                 Compute::income_per_day($slot_recipient->slot_id,$pairing_bonus,'binary',$slot_recipient->slot_owner,$log,$new_slot_id); 
                                                            }
                                                            elseif($gc == true && $new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                                                            {
                                                                    $gcbonus = $pairing_bonus;
                                                                    // Tbl_slot::where('slot_id',$slot_recipient->slot_id)->update(["slot_gc"=>$gcbonus]);
                                                                    $log = $log = "This is your ".$slot_recipient->every_gc_pair." MSB, Your ".$pairing_bonus." Income converted to GC (SLOT #".$slot_recipient->slot_id.") due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right.";
                                                                    Log::slot($slot_recipient->slot_id, $log, $gcbonus,"binary",$new_slot_id,1);
                                                                    // Log::account($slot_recipient->slot_owner, $log);       
                                                            } 

                                                            if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                                                            {
                                                                       /* MATCHING SALE BONUS */
                                                                      Compute::matching($new_slot_id, $method, $slot_recipient, $pairing_bonus);  
                                                            }                                          
                                                }
                                                else
                                                {   
                                                        $binary["left"]   = 0;
                                                        $binary["right"]  = 0;
                                                        $make_it_zero["slot_binary_left"]  = $binary["left"];
                                                        $make_it_zero["slot_binary_right"] = $binary["right"];
                                                        Tbl_slot::id($tree->placement_tree_parent_id)->update($make_it_zero);
                                                        $log = "Im sorry! Max pairing per day already exceed your slot #" . $slot_recipient->slot_id . " flushed out <b>" . number_format($pairing_bonus, 2) . " wallet</b> from <b>MATCHING BONUS</b> due to matching combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining match points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right.";          
                                                        Log::slot_with_flush($slot_recipient->slot_id, $log, 0,"binary",$new_slot_id,$pairing_bonus); 
                                                        // Log::account($slot_recipient->slot_owner, $log);
                                                        $flushpoints =  $flushpoints+$pairing_bonus;
                                                }

                                            }                                                      
                                }                                
              
                        }
                    } 

                    /* UPDATE POINTS */
                    $update_recipient["slot_binary_left"] = $binary["left"];
                    $update_recipient["slot_binary_right"] = $binary["right"];
                    $update_recipient["pair_flush_out_wallet"] = $flushpoints;
                    $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
                    /* UPDATE SLOT CHANGES TO DATABASE */
                    if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
                    {
                        Tbl_slot::id($tree->placement_tree_parent_id)->update($update_recipient);
                    }
                    $update_recipient = null;
                }
            
            }         
    }

    public static function matching($new_slot_id, $method, $slot_recipient_for_binary, $pairing_bonus)
    {
        $slot_recipient_id = $slot_recipient_for_binary->slot_sponsor;

        /* GET SLOT INFO FROM DATABASE */
        // $slot_recipient = Tbl_slot::id($slot_recipient_id)->membership()->first();
           $slot_recipient = null;

        $_tree = Tbl_tree_sponsor::child($slot_recipient_for_binary->slot_id)->level()->distinct_level()->get();
        $matching_setting = Tbl_matching_bonus::get();

        $matching_bonus = null;

        foreach($matching_setting as $key => $level)
        {
            $matching_bonus[$level->membership_id][$level->level]['percent'] =  $level->matching_percentage;
            $matching_bonus[$level->membership_id][$level->level]['count'] =  $level->matching_requirement_count;
            // $matching_bonus[$level->membership_id][$level->level]['member'] =  $level->matching_requirement_membership_id;
            $matching_bonus[$level->membership_id][$level->level]['level'] =  $level->level;
        }
        if($matching_bonus)
        {
            foreach($_tree as $key => $tree)
            {
                    // $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
                    // $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

                    /* GET SLOT INFO */
                    $slot_recipient = Tbl_slot::id($tree->sponsor_tree_parent_id)->membership()->first();
                    if(isset($matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['percent']))
                    { 
                        // $count = 0;
                        $count = Tbl_tree_sponsor::where('sponsor_tree_parent_id',$slot_recipient->slot_id)->where('sponsor_tree_level',1)->count();
                        // foreach($check_requirement as $check)
                        // {
                        //     $check = Tbl_slot::id($tree->sponsor_tree_parent_id)->membership()->first();
                        //     if($check->membership_id == $matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['member'])
                        //     {
                        //         $count++;
                        //     }
                        // }
                        if($count >= $matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['count'])
                        {
                          $matching_income = ($matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['percent']/100)*$pairing_bonus;      
                        }
                        else
                        {
                            $matching_income = 0;
                        }
                    }
                    else
                    {
                            $matching_income = 0;
                    }

                    /* GET INFO OF REGISTREE */
                    // $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();
                    /* COMPUTE FOR THE MATCHING INCOME */


                    if($matching_income != 0)
                    {
                        /* UPDATE WALLET */
                        // $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $matching_income;
                        // $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $matching_income;
                        $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b> " . number_format($matching_income, 2) . " wallet</b> from <b>MENTOR BONUS</b>  due to pairing bonus earned by SLOT #" . $slot_recipient_for_binary->slot_id . ". You current membership is " . $slot_recipient->membership_name . " MEMBERSHIP which has " . number_format($matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['percent'], 2) . "% bonus for every income of your level ".$matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['level']." of your direct sponsor. This bonus is required ".$matching_bonus[$slot_recipient->membership_id][$tree->sponsor_tree_level]['count']." direct.";
                        Compute::income_per_day($slot_recipient->slot_id,$matching_income,'matching',$slot_recipient->slot_owner,$log,$new_slot_id);
                        /* INSERT LOG */
                        // Log::account($slot_recipient->slot_owner, $log);
                        // Log::slot($slot_recipient->slot_id, $log, $matching_income, "MATCHING BONUS");

                        /* UPDATE SLOT CHANGES TO DATABASE */
                        // Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
                    }       
            }            
        }
    }
    public static function direct($new_slot_id, $method = "SLOT CREATION")
    {
        $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();

        /* GET SLOT INFO FROM DATABASE */
        $slot_recipient = Tbl_slot::id($new_slot_info->slot_sponsor)->membership()->first();
        $check_wallet = Tbl_wallet_logs::id($new_slot_info->slot_id)->wallet()->sum('wallet_amount');
        /* ONLY PAID SLOT */
        if($new_slot_info->slot_type != "FS" && $check_wallet >= 0)
        {
            /* CHECK IF SLOT RECIPIENT EXIST */
            if($slot_recipient)
            {
                // $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
                // $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;
                $update_recipient["slot_upgrade_points"] = $slot_recipient->slot_upgrade_points;

                /* GET INFO OF REGISTREE */
                $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();

                /* COMPUTE FOR THE DIRECT INCOME */

                /* Check if percentage or not */
                if($new_slot_info->if_matching_percentage == 1)
                {
                   $direct_income = ($slot_recipient->membership_direct_sponsorship_bonus/100) * $new_slot_info->membership_price;                    
                }
                else
                {
                   $direct_income = $slot_recipient->membership_direct_sponsorship_bonus;        
                }
               

                if($direct_income != 0)
                {
                    /* UPDATE WALLET */
                    // $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $direct_income;
                    // $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $direct_income;
                    $update_recipient["slot_upgrade_points"] = $slot_recipient->slot_upgrade_points + $slot_recipient->member_upgrade_pts;

                    /* INSERT LOG */
                    $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($direct_income, 2) . " wallet</b> through <b>DIRECT SPONSORSHIP BONUS</b> because you've invited SLOT #" . $new_slot_info->slot_id . " to join. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP. Your slot #" . $slot_recipient->slot_id . " also earned <b>" . $slot_recipient->member_upgrade_pts . " Promotion Points</b>.";
                    Compute::income_per_day($slot_recipient->slot_id,$direct_income,'direct',$slot_recipient->slot_owner,$log,$new_slot_id);
                    // Log::account($slot_recipient->slot_owner, $log);
                    // Log::slot($slot_recipient->slot_id, $log, $direct_income, "DIRECT SPONSORSHIP BONUS (DSB)");

                    /* UPDATE SLOT CHANGES TO DATABASE */
                    Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
                }
            }            
        }
                    /* CHECK IF QUALIFIED FOR PROMOTION */                
                    // Compute::check_promotion_qualification($slot_recipient->slot_id);
    }
    public static function indirect($new_slot_id, $method = "SLOT CREATION")
    {
        $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();
        $_indirect_setting = Tbl_indirect_setting::get();
        $_tree = Tbl_tree_sponsor::child($new_slot_id)->level()->distinct_level()->get();

        /* RECORD ALL INTO A SINGLE VARIABLE */
        $indirect_level = null;
        foreach($_indirect_setting as $key => $level)
        {
            $indirect_level[$level->membership_id][$level->level] =  $level->value;
        }

        /* ONLY PAID SLOT */
        if($new_slot_info->slot_type != "FS" && $new_slot_info->slot_wallet >= 0)
        {
            /* CHECK IF LEVEL EXISTS */
            if($indirect_level)
            {
                foreach($_tree as $key => $tree)
                {
                    /* GET SLOT INFO FROM DATABASE */
                    $slot_recipient = Tbl_slot::id($tree->sponsor_tree_parent_id)->membership()->first();
                    // $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
                    // $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

                    /* COMPUTE FOR BONUS */
                    if(isset($indirect_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
                    {
                        $indirect_bonus = $indirect_level[$slot_recipient->membership_id][$tree->sponsor_tree_level];    
                    }
                    else
                    {
                        $indirect_bonus = 0;
                    }
                    
                    /* CHECK IF BONUS IS ZERO */
                    if($indirect_bonus != 0)
                    {
                        /* UPDATE WALLET */
                        // $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $indirect_bonus;
                        // $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $indirect_bonus;
                        $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($indirect_bonus, 2) . " wallet</b> from <b>INDIRECT LEVEL BONUS</b>. You earned it when slot #" . $new_slot_id . " creates a new slot on the Level " . $tree->sponsor_tree_level . " of your sponsor genealogy. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP.";
                        $check = Compute::income_per_day($slot_recipient->slot_id,$indirect_bonus,'indirect',$slot_recipient->slot_owner,$log,$new_slot_id);
                        /* INSERT LOG */




                        /* UPDATE SLOT CHANGES TO DATABASE */
                        // Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
                    }
                }
            }            
        }
    }
    public static function income_per_day($slot_id,$income,$method,$owner,$log,$cause)
    {
                $date = Carbon::now()->toDateString();
                $getslot = Tbl_slot::where('slot_id',$slot_id)->membership()->first();
                $ifnegative = Tbl_wallet_logs::id($slot_id)->wallet()->sum('wallet_amount');

                        if($getslot->slot_today_date == $date)
                        {
                           $total = ($getslot->slot_today_income + $income);

                           if($getslot->max_income < $total && $getslot->max_income <= $getslot->slot_today_income)
                           {
                             // $update['slot_today_income']  =  $getslot->slot_today_income;
                             // $update['slot_flushout']      =  $getslot->slot_flushout + $income;
                             // $update['slot_total_earning'] =  $getslot->slot_total_earning;
                             // $update['slot_wallet'] =  $getslot->slot_wallet;
                             Compute::method_with_flush($method,$slot_id,$income,$owner,$log,$cause);
                             // Tbl_slot::where('slot_id',$slot_id)->update($update);
                           }
                           else if($getslot->max_income < $total)
                           {
                              $total  = $total + (($getslot->max_income - $total)- $getslot->slot_today_income);
                              $total2 = $income - $total;
                              // $update['slot_today_income']  = $getslot->slot_today_income + $total;
                              // $update['slot_total_earning'] = $getslot->slot_total_earning + $total;
                              // $update['slot_flushout']      =  $getslot->slot_flushout + $total2;
                              // $update['slot_wallet'] =  $getslot->slot_wallet + $total;
                              Compute::method_reduced_flush($method,$slot_id,$total,$owner,$log,$total2,$cause);
                              // Compute::put_income_summary($slot_id,$method,$total);
                              // Tbl_slot::where('slot_id',$slot_id)->update($update);
                           }
                           else
                           {
                             // $update['slot_today_income'] = $total; 
                             // $update['slot_total_earning'] = $getslot->slot_total_earning + $income;
                             // $update['slot_wallet'] =  $getslot->slot_wallet + $income;
                             Compute::method_no_flush($method,$slot_id,$income,$owner,$log,$cause);
                             // Compute::put_income_summary($slot_id,$method,$income);
                             // Tbl_slot::where('slot_id',$slot_id)->update($update);
                           }
                        }
                        else
                        {
                           // $update['slot_today_date'] = $date;
                           // $update['slot_today_income'] = $income;
                           // $update['slot_total_earning'] = $getslot->slot_total_earning + $income;
                           // $update['slot_wallet'] =  $getslot->slot_wallet + $income;
                           // Compute::method_no_flush($method,$slot_id,$income,$owner,$log); 

                           $total = $income;

                           if($getslot->max_income < $total && $getslot->max_income <= $getslot->slot_today_income)
                           {
                             // $update['slot_today_income']  =  0;
                             // $update['slot_flushout']      =  $getslot->slot_flushout + $income;
                             // $update['slot_total_earning'] =  $getslot->slot_total_earning;
                             // $update['slot_wallet'] =  $getslot->slot_wallet;
                             Compute::method_with_flush($method,$slot_id,$income,$owner,$log,$cause);
                             // Tbl_slot::where('slot_id',$slot_id)->update($update);
                           }
                           else if($getslot->max_income < $total)
                           {
                              $total  = $total + (($getslot->max_income - $total)- $getslot->slot_today_income);
                              $total2 = $income - $total;
                              // $update['slot_today_income']  = $total;
                              // $update['slot_total_earning'] = $getslot->slot_total_earning + $total;
                              // $update['slot_flushout']      =  $getslot->slot_flushout + $total2;
                              // $update['slot_wallet'] =  $getslot->slot_wallet + $total;
                              Compute::method_reduced_flush($method,$slot_id,$total,$owner,$log,$total2,$cause);
                              // Compute::put_income_summary($slot_id,$method,$total);
                              // Tbl_slot::where('slot_id',$slot_id)->update($update);
                           }
                           else
                           {
                             // $update['slot_today_income'] = $total; 
                             // $update['slot_total_earning'] = $getslot->slot_total_earning + $income;
                             // $update['slot_wallet'] =  $getslot->slot_wallet + $income;
                             Compute::method_no_flush($method,$slot_id,$income,$owner,$log,$cause);
                             // Compute::put_income_summary($slot_id,$method,$income);
                             // Tbl_slot::where('slot_id',$slot_id)->update($update);
                           }
                        }                        
                     
                 if($getslot->slot_type == "CD")
                 {
                     if($ifnegative >= 0)
                     {
                        $update = null;
                        $update["slot_type"] = "PS";
                        $message = "Your slot #".$slot_id." becomes a paid slot.";
                        Log::slot($slot_id, $message, 0, "CD to PS",$slot_id);
                        $vouch = DB::table('tbl_voucher')->where('slot_id',$slot_id)->first();
                        if($vouch)
                        {
                            $check = Tbl_voucher::where('tbl_voucher.voucher_id',$vouch->voucher_id)->update(["status"=>"unclaimed"]);
                        }
                        Compute::binary($slot_id, "CD TO PS");
                        Compute::direct($slot_id, "CD TO PS");
                        Tbl_slot::where('slot_id',$slot_id)->update($update);
                     }                   
                 }                    
                
    }
    public static function method_no_flush($method,$slot_id,$income,$owner,$log,$cause)
    {
                    Log::slot($slot_id, $log, $income, $method,$cause);
                    // Log::account($owner, $log);            
    }
    public static function method_with_flush($method,$slot_id,$income,$owner,$log,$cause)
    {
                    $log = "Im sorry! You have already reach the max income for today, Your slot #" . $slot_id.' flushed out '.number_format($income, 2) . " wallet.";
                    // Log::account($owner, $log);
                    Log::slot_with_flush($slot_id, $log,0, $method,$cause,$income);             
    }
    public static function method_reduced_flush($method,$slot_id,$income,$owner,$log,$flush,$cause)
    {
                    $log = $log." Max income is reached, wallet earned reduced to <b>".$income."</b> and flushed out <b>".$flush.'</b>.';
                    // Log::account($owner, $log);
                    Log::slot_with_flush($slot_id, $log, $income, $method,$cause,$flush);             
    }
    public static function put_income_summary($slot_id,$method,$amount)
    {
            if($method == "direct")
            {
                $get = Tbl_slot::where('slot_id',$slot_id)->first();                
                $update['total_earned_direct'] = $get->total_earned_direct + $amount;
                Tbl_slot::where('slot_id',$slot_id)->update($update); 
                $update = null;
            }
            else if($method == "indirect")
            {
                $get = Tbl_slot::where('slot_id',$slot_id)->first();                
                $update['total_earned_indirect'] = $get->total_earned_indirect + $amount;
                Tbl_slot::where('slot_id',$slot_id)->update($update); 
                $update = null;
            }
            else if($method == "binary")
            {
                $get = Tbl_slot::where('slot_id',$slot_id)->first();                
                $update['total_earned_binary'] = $get->total_earned_binary + $amount;
                Tbl_slot::where('slot_id',$slot_id)->update($update); 
                $update = null;
            }
            else if($method == "matching")
            {
                $get = Tbl_slot::where('slot_id',$slot_id)->first();                
                $update['total_earned_matching'] = $get->total_earned_matching + $amount;
                Tbl_slot::where('slot_id',$slot_id)->update($update); 
                $update = null;
            }
    }

    public static function compute_travel($slot)
    {
        $reward = null;
        $points = 0 ;


        $required = Tbl_travel_qualification::where('archived',0)->get();

        foreach($required as $key => $r)
        {
            if($r->travel_qualification_name == "Direct Referral")
            {
                $count = Tbl_tree_sponsor::where('sponsor_tree_parent_id',$slot->slot_id)->where('sponsor_tree_level',1)->count();
                if($count >= $r->item)
                {
                    $points = $points + $r->points;
                }
            }
            elseif($r->travel_qualification_name == "Total Spent")
            {
                $count = Tbl_wallet_logs::id($slot->slot_id)->wallet()->where('wallet_amount','<=',0)->sum('wallet_amount');
                $count = $count * (-1);

                if($count >= $r->item)
                {
                    $points = $points + $r->points;
                }          
            }
            elseif($r->travel_qualification_name == "Total Income")
            {
                $count = Tbl_wallet_logs::id($slot->slot_id)->wallet()->where('wallet_amount','>=',0)->sum('wallet_amount');
                if($count >= $r->item)
                {
                    $points = $points + $r->points;
                }  
            }
            elseif($r->travel_qualification_name == "Total Downline")
            {
                $count = Tbl_tree_placement::where('placement_tree_parent_id',$slot->slot_id)->count();
                if($count >= $r->item)
                {
                    $points = $points + $r->points;
                }  
            }
        }

        $reward = Tbl_travel_reward::where('archived',0)->where('required_points','<=',$points)->orderBy('required_points','DESC')->first();

        $data['points'] = $points;
        $data['reward'] = $reward;

        return $data;
    }

    public static function delete_slot($slot_id)
    {

        $delete_slot = Tbl_slot::id($slot_id)->first();

        if($delete_slot->slot_type != 'CD' && $delete_slot->slot_type != 'FS')
        {
                $c = Carbon::now()->toDateString();

                $d = Carbon::parse($delete_slot->created_at)->toDateString();

                if($d == $c)
                {
                    $condition = true;
                }
                else
                {
                    $condition = false;
                }

                $get_membership = DB::table('tbl_binary_pairing')->where('membership_id',$delete_slot->slot_membership)->first();
                $binary_l = $get_membership->pairing_point_l;
                $binary_r = $get_membership->pairing_point_r;

                $get = Tbl_wallet_logs::where('cause_id',$slot_id)->where('keycode','binary')->get();
  
                foreach($get as $g)
                {
                    $slot_info = Tbl_slot::id($g->slot_id)->first();

                    $update['slot_binary_left']  = $slot_info->slot_binary_left  + $binary_l;
                    $update['slot_binary_right'] = $slot_info->slot_binary_right + $binary_r;
                    if($condition == true)
                    {
                        $update['pairs_today'] = $slot_info->pairs_today - 1;            
                    }

                    Tbl_slot::id($g->slot_id)->update($update);
                    $update = null;
                }

                $get = Tbl_tree_placement::where('placement_tree_child_id',$slot_id)->get();
                foreach($get as $g)
                {
                    $slot_info = Tbl_slot::id($g->placement_tree_parent_id)->first();   

                    if($g->placement_tree_position == "left")
                    {
                        $update['slot_binary_left']  = $slot_info->slot_binary_left  - $binary_l;
                        Tbl_slot::id($g->placement_tree_parent_id)->update($update); 
                    }
                    elseif($g->placement_tree_position =="right")
                    {
                        $update['slot_binary_right'] = $slot_info->slot_binary_right - $binary_r; 
                        Tbl_slot::id($g->placement_tree_parent_id)->update($update);               
                    }

                    $update = null; 
                }            
        }
       
    }
}