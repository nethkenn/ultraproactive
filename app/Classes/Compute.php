<?php namespace App\Classes;
use App\Tbl_slot;
use App\Tbl_tree_placement;
use App\Tbl_tree_sponsor;
use App\Tbl_binary_pairing;

class Compute
{
    public static function tree($new_slot_id)
    {
    	$slot_info = Tbl_slot::id($new_slot_id)->first();
    	MLM::insert_tree_placement($slot_info, $new_slot_id, 1); /* TREE RECORD FOR BINARY GENEALOGY */
    	MLM::insert_tree_sponsor($slot_info, $new_slot_id, 1); /* TREE RECORD FOR SPONSORSHIP GENEALOGY */
    }
    public static function computation($new_slot_id, $method = "SLOT CREATION")
    {
        MLM::binary($new_slot_id, $method);
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
            MLM::insert_tree_placement($upline_info, $new_slot_id, $level);  
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
            MLM::insert_tree_sponsor($upline_info, $new_slot_id, $level);  
        }
    }
    public static function binary($new_slot_id, $method = "SLOT CREATION")
    {
        $new_slot_info = Tbl_slot::id($new_slot_id)->membership()->first();

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

    		/* CHECK PAIRING */
    		while($binary["left"] >= $required_pairing_points && $binary["right"] >= $required_pairing_points)
    		{
    			$binary["left"] = $binary["left"] - $required_pairing_points;
    			$binary["right"] = $binary["right"] - $required_pairing_points;

    			/* UPDATE WALLET */
    			$update_recipient["slot_wallet"] = $update_recipient["slot_wallet"] + 1000;
    			$update_recipient["slot_total_earning"] = $update_recipient["slot_total_earning"] + 1000;

    			/* INSERT LOG */
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