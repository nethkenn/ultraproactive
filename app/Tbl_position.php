<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_position extends Model
{
	protected $table = 'tbl_admin_position';
	protected $primaryKey = 'admin_position_id';
	protected $fillable = ['admin_position_name', 'admin_position_rank', 'archived'];

	public $timestamps = false;

    public function module()
    {

        return $this->belongsToMany('App\Tbl_module', 'tbl_admin_position_has_module', 'admin_position_id', 'module_id');
    }


    

    
}