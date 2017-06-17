<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_opportunity extends Model
{
    protected $table = 'tbl_opportunity';
	protected $primaryKey = "opportunity_id";
	public $timestamps = false;
}
