<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_admin_position_has_module extends Model
{
	protected $table = 'tbl_admin_position_has_module';
	protected $primaryKey = "has_id";
	protected $fillable = ['admin_position_id', 'module_id'];  
	public $timestamps = false;


	public function scopeModule($query)
    {

        return $query->leftJoin('tbl_module', 'tbl_module.module_id', '=', 'tbl_admin_position_has_module.module_id');

        // return $query->leftJoin('tbl_slot', 'tbl_slot.slot_owner', '=', 'tbl_admin.account_id')->select(DB::raw('count(*) as slot_count, tbl_admin.account_id'))->groupBy('tbl_admin.account_id');

    }


}
