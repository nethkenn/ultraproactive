<?php namespace App\Classes;
use App\Tbl_slot;
use App\Tbl_tree_placement;
use App\Tbl_tree_sponsor;
use App\Tbl_binary_pairing;
use App\Tbl_indirect_setting;
use App\Tbl_unilevel_setting;
use App\Tbl_membership;
use App\Classes\Log;


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
    public static function repurchase($buyer_slot_id, $binary_pts, $unilevel_pts, $method = "REPURCHASE")
    {
        Compute::unilevel_repurchase($buyer_slot_id, $unilevel_pts, $method);
        Compute::binary_repurchase($buyer_slot_id, $binary_pts, $method);
    }
    public static function unilevel_repurchase($buyer_slot_id, $unilevel_pts, $method)
    {
        $buyer_slot_info = Tbl_slot::id($buyer_slot_id)->account()->membership()->first();

        /* ----- COMPUTATION OF PERSONAL PV */
        $update_recipient["slot_personal_points"] = $buyer_slot_info->slot_personal_points + $unilevel_pts;

        /* INSERT LOG */
        $log = "Your slot #" . $buyer_slot_info->slot_id . " earned <b>" . number_format($unilevel_pts, 2) . " personal pv</b>.";
        Log::account($buyer_slot_info->slot_owner, $log);

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
                }
                else
                {
                    $unilevel_bonus = 0;
                }
                
                /* CHECK IF BONUS IS ZERO */
                if($unilevel_bonus != 0)
                {
                    /* UPDATE WALLET */
                    $update_recipient["slot_group_points"] = $update_recipient["slot_group_points"] + $unilevel_bonus;
                    $update_recipient["slot_upgrade_points"] = $update_recipient["slot_upgrade_points"] + $unilevel_bonus;
                    /* INSERT LOG */
                    $log = "Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($unilevel_bonus, 2) . " group pv and promotion points</b>. You earned it when slot #" . $buyer_slot_id . " uses a code worth " . number_format($unilevel_pts, 2) . " PV. That slot is located on the Level " . $tree->sponsor_tree_level . " of your sponsor genealogy. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP.";
                    Log::account($slot_recipient->slot_owner, $log);

                    /* UPDATE SLOT CHANGES TO DATABASE */
                    Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);

                    /* CHECK IF QUALIFIED FOR PROMOTION */
                    Compute::check_promotion_qualification($slot_recipient->slot_id);
                }
            }
        }
    }
    public static function binary_repurchase($buyer_slot_id, $binary_pts, $method)
    {
        $new_slot_info = Tbl_slot::id($buyer_slot_id)->account()->membership()->first();
        $_pairing = Tbl_binary_pairing::orderBy("pairing_point_l", "desc")->get();

        /* GET SETTINGS */
        $required_pairing_points = 100;

        /* GET THE TREE */
        $_tree = Tbl_tree_placement::child($buyer_slot_id)->level()->distinct_level()->get();

        /* UPDATE BINARY POINTS */
        foreach($_tree as $tree)
        {
            /* GET SLOT INFO FROM DATABASE */
            $slot_recipient = Tbl_slot::id($tree->placement_tree_parent_id)->first();
            $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
            $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

            /* RETRIEVE LEFT & RIGHT POINTS */
            $binary["left"] = $slot_recipient->slot_binary_left;
            $binary["right"] = $slot_recipient->slot_binary_right; 

            /* ADD NECESARRY POINTS */
            $earned_points = $binary_pts;

            /* CHECK POINTS EARNED */
            if($earned_points != 0)
            {
                $binary[$tree->placement_tree_position] = $binary[$tree->placement_tree_position] + $earned_points; 
                
                /* INSERT LOG FOR EARNED POINTS IN ACCOUNT */
                $log = "Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($earned_points, 2) . " binary points</b> on " . $tree->placement_tree_position . " when " . $new_slot_info->account_name . " used one if his/her product code.";
                Log::account($slot_recipient->slot_owner, $log);

                /* CHECK PAIRING */
                foreach($_pairing as $pairing)
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
                            /* UPDATE WALLET */
                            $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $pairing_bonus;
                            $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $pairing_bonus;

                            /* INSERT LOG */
                            $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($pairing_bonus, 2) . " wallet</b> from <b>PAIRING BONUS</b> due to pairing combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining binary points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right. This combination was caused by a repurchase of one of your downlines.";
                            Log::account($slot_recipient->slot_owner, $log);
                            Log::slot($slot_recipient->slot_id, $log, $pairing_bonus, "BINARY PAIRING");

                            /* MATCHING SALE BONUS */
                            Compute::matching($buyer_slot_id, "REPURCHASE", $slot_recipient, $pairing_bonus);
                        }
                    }
                } 

                /* UPDATE POINTS */
                $update_recipient["slot_binary_left"] = $binary["left"];
                $update_recipient["slot_binary_right"] = $binary["right"];

                /* UPDATE SLOT CHANGES TO DATABASE */
                Tbl_slot::id($tree->placement_tree_parent_id)->update($update_recipient);
                $update_recipient = null;
            }
        }
    }
    public static function check_promotion_qualification($slot_id)
    {
        $slot_info = Tbl_slot::membership()->id($slot_id)->first();

        if($slot_info->upgrade_via_points == 1)
        {
            $data["next_membership"] = Tbl_membership::where("membership_required_upgrade", ">",  $slot_info->membership_required_upgrade)->orderBy("membership_required_upgrade", "asc")->first();

            if($data["next_membership"])
            {
                /* CHECK IF QUALIFIED FOR UPGRADE */
                if($slot_info->slot_upgrade_points >= $data["next_membership"]->membership_required_upgrade)
                {
                    $update_slot["slot_upgrade_points"] = 0;
                    $update_slot["slot_membership"] = $data["next_membership"]->membership_id;
                    $log = "Congratulation! Slot #" . $slot_id . " has been promoted from " . $slot_info->membership_name . " to " . $data["next_membership"]->membership_name . " when " . number_format($data["next_membership"]->membership_required_upgrade, 2) . " Promotion Points has been reached.";
                    Tbl_slot::id($slot_id)->update($update_slot);
                    Log::account($slot_info->slot_owner, $log);
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
    		$slot_recipient = Tbl_slot::id($tree->placement_tree_parent_id)->first();
    		$update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
    		$update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

    		/* RETRIEVE LEFT & RIGHT POINTS */
    		$binary["left"] = $slot_recipient->slot_binary_left;
    		$binary["right"] = $slot_recipient->slot_binary_right; 

    		/* ADD NECESARRY POINTS */
            $earned_points = $new_slot_info->membership_binary_points;

            /* CHECK POINTS EARNED */
            if($earned_points != 0)
            {
                $binary[$tree->placement_tree_position] = $binary[$tree->placement_tree_position] + $earned_points; 
                
                /* INSERT LOG FOR EARNED POINTS IN ACCOUNT */
                $log = "Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($earned_points, 2) . " binary points</b> on " . $tree->placement_tree_position . " when " . $new_slot_info->account_name . " with " . $new_slot_info->membership_name . " MEMBERSHIP created a new slot (#" . $new_slot_info->slot_id . ").";
                Log::account($slot_recipient->slot_owner, $log);

                /* CHECK PAIRING */
                foreach($_pairing as $pairing)
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
                            /* UPDATE WALLET */
                            $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $pairing_bonus;
                            $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $pairing_bonus;

                            /* INSERT LOG */
                            $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($pairing_bonus, 2) . " wallet</b> from <b>PAIRING BONUS</b> due to pairing combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . "). Your slot's remaining binary points is " . $binary["left"] . " point(s) on left and " . $binary["right"] . " point(s) on right.";
                            Log::account($slot_recipient->slot_owner, $log);
                            Log::slot($slot_recipient->slot_id, $log, $pairing_bonus, "BINARY PAIRING");

                            /* MATCHING SALE BONUS */
                            Compute::matching($new_slot_id, $method, $slot_recipient, $pairing_bonus);
                        }
                    }
                } 

                /* UPDATE POINTS */
                $update_recipient["slot_binary_left"] = $binary["left"];
                $update_recipient["slot_binary_right"] = $binary["right"];

                /* UPDATE SLOT CHANGES TO DATABASE */
                Tbl_slot::id($tree->placement_tree_parent_id)->update($update_recipient);
                $update_recipient = null;
            }
    	}
    }
    public static function matching($new_slot_id, $method, $slot_recipient_for_binary, $pairing_bonus)
    {
        $slot_recipient_id = $slot_recipient_for_binary->slot_sponsor;

        /* GET SLOT INFO FROM DATABASE */
        $slot_recipient = Tbl_slot::id($slot_recipient_id)->membership()->first();

        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_recipient)
        {
            $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
            $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

            /* GET INFO OF REGISTREE */
            $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();

            /* COMPUTE FOR THE MATCHING INCOME */
            $matching_income = ($slot_recipient->membership_matching_bonus/100) * $pairing_bonus;

            if($matching_income != 0)
            {
                /* UPDATE WALLET */
                $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $matching_income;
                $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $matching_income;

                /* INSERT LOG */
                $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($matching_income, 2) . " wallet</b> from <b>MATCHING BONUS</b>  due to pairing bonus earned by SLOT #" . $slot_recipient_for_binary->slot_id . ". You current membership is " . $slot_recipient->membership_name . " MEMBERSHIP which has " . number_format($slot_recipient->membership_matching_bonus, 2) . "% bonus for every income of your direct sponsor.";
                Log::account($slot_recipient->slot_owner, $log);
                Log::slot($slot_recipient->slot_id, $log, $matching_income, "MATCHING BONUS");

                /* UPDATE SLOT CHANGES TO DATABASE */
                Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
            }
        }
    }
    public static function direct($new_slot_id, $method = "SLOT CREATION")
    {
        $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();

        /* GET SLOT INFO FROM DATABASE */
        $slot_recipient = Tbl_slot::id($new_slot_info->slot_sponsor)->membership()->first();

        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_recipient)
        {
            $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
            $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;
            $update_recipient["slot_upgrade_points"] = $slot_recipient->slot_wallet;

            /* GET INFO OF REGISTREE */
            $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();

            /* COMPUTE FOR THE DIRECT INCOME */
            $direct_income = ($slot_recipient->membership_direct_sponsorship_bonus/100) * $new_slot_info->membership_price;

            if($direct_income != 0)
            {
                /* UPDATE WALLET */
                $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $direct_income;
                $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $direct_income;
                $update_recipient["slot_upgrade_points"] = $slot_recipient->slot_upgrade_points + $slot_recipient->membership_binary_points;

                /* INSERT LOG */
                $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($direct_income, 2) . " wallet</b> through <b>DIRECT SPONSORSHIP BONUS</b> because you've invited SLOT #" . $new_slot_info->slot_id . " to join. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP. Your slot #" . $slot_recipient->slot_id . " also earned <b>" . number_format($slot_recipient->membership_binary_points, 2) . " Promotion Points</b>.";
                Log::account($slot_recipient->slot_owner, $log);
                Log::slot($slot_recipient->slot_id, $log, $direct_income, "DIRECT SPONSORSHIP BONUS (DSB)");

                /* UPDATE SLOT CHANGES TO DATABASE */
                Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);

                /* CHECK IF QUALIFIED FOR PROMOTION */
                Compute::check_promotion_qualification($slot_recipient->slot_id);
            }
        }
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

        /* CHECK IF LEVEL EXISTS */
        if($indirect_level)
        {
            foreach($_tree as $key => $tree)
            {
                /* GET SLOT INFO FROM DATABASE */
                $slot_recipient = Tbl_slot::id($tree->sponsor_tree_parent_id)->membership()->first();
                $update_recipient["slot_wallet"] = $slot_recipient->slot_wallet;
                $update_recipient["slot_total_earning"] = $slot_recipient->slot_total_earning;

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
                    $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $indirect_bonus;
                    $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $indirect_bonus;

                    /* INSERT LOG */
                    $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($indirect_bonus, 2) . " wallet</b> from <b>INDIRECT LEVEL BONUS</b>. You earned it when slot #" . $new_slot_id . " creates a new slot on the Level " . $tree->sponsor_tree_level . " of your sponsor genealogy. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP.";
                    Log::account($slot_recipient->slot_owner, $log);
                    Log::slot($slot_recipient->slot_id, $log, $indirect_bonus, "INDIRECT LEVEL BONUS");

                    /* UPDATE SLOT CHANGES TO DATABASE */
                    Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
                }
            }
        }
    }
}