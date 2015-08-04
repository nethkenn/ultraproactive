<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_beneficiary_rel extends Model
{
	protected $table = 'tbl_beneficiary_rel';
	protected $primaryKey = 'beneficiary_rel_id';
	protected $fillable = [
							'relation'

	 						];

	public $timestamps = false;

}

