<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_service_charge extends Model
{
	protected $table = 'tbl_service_charge';
	protected $primaryKey = 'service_charge_id';
	protected $fillable = [
							'service_charge_name',
							'currency',
							'archived',
	 						];




}