<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_admin extends Model
{
    //
    protected $table = "tbl_admin";
    protected $primaryKey = "admin_id";
    protected $fillable = ['account_id','admin_position_id'];

    public $timestamps = false;

    // public function account()
    // {
    //    return $this->belongsTo('App\Tbl_account','account_id');
    // }

    // public function position()
    // {
    //     return $this->hasOne('App\Tbl_position', 'admin_position_id');
    // }


    public function scopeAccount($query)
    {
        return $query->leftJoin('tbl_account', 'tbl_account.account_id', '=', 'tbl_admin.account_id');
    }


    public function scopePosition($query)
    {
        return $query->leftJoin('tbl_admin_position', 'tbl_admin_position.admin_position_id', '=', 'tbl_admin.admin_position_id');
    }


    public function scopeSlot($query)
    {

        return $query->leftJoin('tbl_slot', 'tbl_slot.slot_owner', '=', 'tbl_admin.account_id');

        // return $query->leftJoin('tbl_slot', 'tbl_slot.slot_owner', '=', 'tbl_admin.account_id')->select(DB::raw('count(*) as slot_count, tbl_admin.account_id'))->groupBy('tbl_admin.account_id');

    }

    

}
