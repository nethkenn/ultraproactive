<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_admin_log extends Model
{
    //
    protected $table = "tbl_admin_log";
    protected $primaryKey = "admin_log_id";

    public function scopeAccount($query)
    {
        return $query->leftJoin("tbl_account", "tbl_account.account_id", "=", "tbl_admin_log.account_id");
    }
    public function scopePosition($query)
    {
        return $query->leftJoin('tbl_admin_position', 'tbl_admin_position.admin_position_id', '=', 'tbl_admin.admin_position_id');
    }
	public function scopeAdmin($query)
    {
        return $query->leftJoin('tbl_admin', 'tbl_admin.account_id', '=', 'tbl_admin_log.account_id');
    }
}
