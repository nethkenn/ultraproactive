<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tbl_tree_placement extends Model
{
	protected $table = 'tbl_tree_placement';
	protected $primaryKey = 'placement_tree_id';

    public function scopeChild($query, $slot_id)
    {
        return $query->where("placement_tree_child_id", $slot_id);
    }
    public function scopeParent_info($query)
    {
        return $query->join("tbl_slot", "tbl_slot.slot_id", "=", "tbl_tree_placement.placement_tree_parent_id");
    }
}
