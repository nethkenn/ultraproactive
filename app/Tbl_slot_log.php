<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_account_log extends Model
{
	protected $table = 'Tbl_slot_log';
	protected $primaryKey = "slot_log_id";

    public function index()
    {
    }
}