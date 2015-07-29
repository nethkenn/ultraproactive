<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tbl_tree_sponsor extends Model
{
	protected $table = 'tbl_tree_sponsor';
	protected $primaryKey = 'sponsor_tree_id';

    public function scopeChild($query, $slot_id)
    {
        return $query->where("sponsor_tree_child_id", $slot_id);
    }
    public function scopeParent_info($query)
    {
        return $query->join("tbl_slot", "tbl_slot.slot_id", "=", "tbl_tree_sponsor.sponsor_tree_parent_id");
    }
    public function scopeLevel($query)
    {
        return $query->orderby("sponsor_tree_level", "desc");
    }
    public function scopeDistinct_level($query)
    {
        return $query->groupBy("sponsor_tree_level");
    }
}
