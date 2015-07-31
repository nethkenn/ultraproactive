<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_module extends Model
{
	protected $table = 'tbl_module';
	protected $primaryKey = 'module_id';
	protected $fillable = ['module_name', 'archived', 'url_segment'];

	public $timestamps = false;



	public function position()
    {
        // return $this->belongsTo('App\Tbl_admin');

        return $this->belongsToMany('App\Tbl_position', 'tbl_admin_position_has_module',  'module_id', 'admin_position_id');
    }
}