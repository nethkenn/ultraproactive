<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_position extends Model
{
	protected $table = 'tbl_admin_position';
	protected $primaryKey = 'admin_position_id';

    public function position()
    {
        return $this->belongsTo('App\Tbl_admin');
    }
}