<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tbl_slot extends Model
{
	protected $table = 'tbl_slot';
	protected $primaryKey = 'slot_id';
    public $timestamps = false;
    
    public function scopeRank($query)
    {
        return $query->leftJoin("tbl_rank", "tbl_rank.rank_id", "=", "tbl_slot.slot_rank");
    }
    public function scopeMembership($query)
    {
        return $query->leftJoin("tbl_membership", "tbl_membership.membership_id", "=", "tbl_slot.slot_membership");
    }
    public function scopeAccount($query)
    {
        return $query->leftJoin("tbl_account", "tbl_account.account_id", "=", "tbl_slot.slot_owner");
    }
    public function scopeId($query, $slot_id)
    {
        return $query->where("slot_id", $slot_id);
    }
    public function scopePlacement($query, $slot_id)
    {
        return $query->where("placement", $slot_id);
    }
    public function scopeCheckposition($query, $placement, $position)
    {
        return $query->where("slot_position", $position)->where("slot_placement", $placement);
    }
    public function scopeChosenProduct($query)
    {
        return $query->leftjoin('Rel_membership_product','Rel_membership_product.slot_id','=','Tbl_slot.slot_id');
    }
    public function scopeGetChosen($query)
    {
        return $query->leftjoin('tbl_product_package_has','tbl_product_package_has.product_package_id','=','Rel_membership_product.product_package_id');
    }


}
