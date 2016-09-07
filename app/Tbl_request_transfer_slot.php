<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_request_transfer_slot extends Model
{
	protected $table = 'tbl_request_transfer_slot';
	protected $primaryKey = 'transfer_id';
	public $timestamps = false;
}