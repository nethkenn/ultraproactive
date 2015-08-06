<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_stockist_type extends Model
{
	protected $table = 'tbl_stockist_type';
	protected $primaryKey = 'stockist_type_id';
	protected $fillable = [
							'stockist_type_name',
							'stockist_type_discount',
							'stockist_type_package_discount',
							'stockist_type_minimum_order',
							'archive',
	 						];
	public $timestamps = false;

}