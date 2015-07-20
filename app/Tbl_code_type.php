<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_code_type extends Model
{
	protected $table = 'tbl_code_type';
	protected $primaryKey = 'code_type_id';
	public $timestamps = false;


	public function code()
    {
        return $this->belongsTo('App\Tbl_membership_code','code_type_id');
    }
}