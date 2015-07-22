<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_account_log extends Model
{
	protected $table = 'Tbl_account_log';
	protected $primaryKey = "account_log_id";

    public function index()
    {
    }
}