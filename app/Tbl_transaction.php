<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_transaction extends Model
{
	protected $table = 'tbl_transaction';
	protected $primaryKey = 'transaction_id';
    // protected $primaryKey = 'id'; 
    public $timestamps = false;

}
