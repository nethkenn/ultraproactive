<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_account_encashment_history extends Model
{
	protected $table = 'tbl_account_encashment_history';
	protected $primaryKey = "request_id";
    public $timestamps = false;

    public function scopeAccount($query)
    {
        return $query->leftJoin('tbl_account', 'tbl_account.account_id', '=', 'tbl_account_encashment_history.account_id');
    }

}
