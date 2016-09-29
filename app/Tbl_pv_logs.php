<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_pv_logs extends Model
{
	protected $table = 'tbl_pv_logs';
	protected $primaryKey = "personal_pv_logs_id";

	public $timestamps = false;
}