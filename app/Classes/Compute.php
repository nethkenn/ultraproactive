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
    public static function computation($new_slot_id, $method = "SLOT CREATION")
    {
        Compute::binary($new_slot_id, $method);
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
    		$binary[$tree->placement_tree_position] = $binary[$tree->placement_tree_position] + $new_slot_info->membership_binary_points; 
            
            /* INSERT LOG FOR EARNED POINTS IN ACCOUNT */
            $log = "Your slot #" . $slot_recipient->slot_id . " earned <b>" . number_format($new_slot_info->membership_binary_points, 2) . " binary points</b> on " . $tree->placement_tree_position . " when " . $new_slot_info->account_name . " with " . $new_slot_info->membership_name . " MEMBERSHIP created a new slot(" . $new_slot_info->slot_id . ").";
            
            Log::account($slot_recipient->slot_owner, $log);


    		/* CHECK PAIRING */
            foreach($_pairing as $pairing)
            {
                while($binary["left"] >= $pairing->pairing_point_l && $binary["right"] >= $pairing->pairing_point_r)
                {
                    $binary["left"] = $binary["left"] - $pairing->pairing_point_l;
                    $binary["right"] = $binary["right"] - $pairing->pairing_point_r;

                    /* UPDATE WALLET */
                    $update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + $pairing->pairing_income;
                    $update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + $pairing->pairing_income;

                    /* INSERT LOG */
                    $log = "Your slot #" . $new_slot_info->slot_id . " earned <b>" . number_format($pairing->pairing_income, 2) . " wallet</b> due to pairing combination (" . $pairing->pairing_point_l .  ":" . $pairing->pairing_point_r . ").";
                    Log::account($slot_recipient->slot_owner, $log);
                    Log::slot($slot_recipient->slot_id, $log, $pairing->pairing_income);
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