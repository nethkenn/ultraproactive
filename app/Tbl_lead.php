<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_lead extends Model
{
	protected $table = 'tbl_lead';
	public $timestamps = false;

	public function scopeGetAccount($query)
    {
        return $query->leftJoin('tbl_account','tbl_account.account_id','=','tbl_lead.account_id');
    }
    public function scopeGetSlot($query)
    {
        return $query->leftJoin('tbl_slot','tbl_slot.slot_owner','=','tbl_lead.lead_account_id');
    }
}