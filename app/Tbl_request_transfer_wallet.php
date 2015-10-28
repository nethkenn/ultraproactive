<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_request_transfer_wallet extends Model
{
	protected $table = 'tbl_request_transfer_wallet';
	protected $primaryKey = 'transfer_id';
	public $timestamps = false;

	public function scopeAccount($query)
    {
		return $query->join("tbl_account", "tbl_account.account_id", "=", "tbl_slot.slot_owner");
    }
    public function scopeSlot($query)
    {
    	return $query->join("tbl_slot", "tbl_slot.slot_id", "=", "tbl_request_transfer_wallet.received_slot_by");
    }
    public function scopeAccountby($query)
    {
        return $query->join("tbl_account", "tbl_account.account_id", "=", "tbl_slot.slot_owner");
    }
    public function scopeSlotby($query)
    {
        return $query->join("tbl_slot", "tbl_slot.slot_id", "=", "tbl_request_transfer_wallet.sent_slot_by");
    }
}