<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tbl_item_packages extends Model
{
    protected $table = 'tbl_item_packages';
	protected $primaryKey = "item_package_id";
	public $timestamps = false;
}
