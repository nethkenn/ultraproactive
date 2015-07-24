<?php namespace App\Classes;
use App\Tbl_slot;
use App\Tbl_tree_placement;
use App\Tbl_tree_sponsor;
use App\Tbl_binary_pairing;
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
    	$_tree = Tbl_tree_placement::child($new_slot_id)->get();

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
                            Log::slot($slot_recipient->slot_id, $log, $pairing_bonus);

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

            /* UPDATE WALLET */
            $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $matching_income;
            $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $matching_income;

            /* INSERT LOG */
            $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($matching_income, 2) . " wallet</b> from <b>MATCHING BONUS</b>  due to pairing bonus earned by SLOT #" . $slot_recipient_for_binary->slot_id . ". You current membership is " . $slot_recipient->membership_name . " MEMBERSHIP which has " . number_format($slot_recipient->membership_matching_bonus, 2) . "% bonus for every income of your direct sponsor.";
            Log::account($slot_recipient->slot_owner, $log);
            Log::slot($slot_recipient->slot_id, $log, $matching_income);

            /* UPDATE SLOT CHANGES TO DATABASE */
            Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
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

            /* GET INFO OF REGISTREE */
            $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();

            /* COMPUTE FOR THE MATCHING INCOME */
            $direct_income = ($slot_recipient->membership_matching_bonus/100) * $new_slot_info->membership_price;

            /* UPDATE WALLET */
            $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $direct_income;
            $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $direct_income;

            /* INSERT LOG */
            $log = "Congratulations! Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($direct_income, 2) . " wallet</b> through <b>DIRECT SPONSORSHIP BONUS</b> because you've invited SLOT #" . $new_slot_info->slot_id . " to join. Your current membership is " . $slot_recipient->membership_name . " MEMBERSHIP.";
            Log::account($slot_recipient->slot_owner, $log);
            Log::slot($slot_recipient->slot_id, $log, $direct_income);

            /* UPDATE SLOT CHANGES TO DATABASE */
            Tbl_slot::id($slot_recipient->slot_id)->update($update_recipient);
        }
    }
    public static function indirect($new_slot_id, $method = "SLOT CREATION")
    {
        $new_slot_info = Tbl_slot::id($new_slot_id)->account()->membership()->first();
    }
}