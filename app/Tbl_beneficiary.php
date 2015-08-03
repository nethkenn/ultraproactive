<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_beneficiary extends Model
{
	protected $table = 'tbl_beneficiary';
	protected $primaryKey = 'beneficiary_id';
	protected $fillable = [
							'f_name',
							'l_name',
							'm_name',
							'gender',
							'beneficiary_rel_id',
	 						];

	public $timestamps = false;

}

