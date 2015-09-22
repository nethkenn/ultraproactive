<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_Wallet_logs extends Model
{
	protected $table = 'tbl_Wallet_logs';
	protected $primaryKey = "wallet_logs_id";

	public $timestamps = false;

    public function scopeId($query, $slot_id)
    {
        return $query->where("slot_id", $slot_id);
    }

    public function scopeTotal($query)
    {
        return $query->sum('wallet_amount');
    }

    public function scopeWallet($query)
    {
        return $query->where('wallet_type','Wallet');
    }

    public function scopeGC($query)
    {
        return $query->where('wallet_type','GC');
    }
}