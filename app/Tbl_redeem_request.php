<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tbl_redeem_request extends Model
{
	protected $table = 'tbl_redeem_request';
	protected $primaryKey = 'request_id';
    public $timestamps = false;

}
