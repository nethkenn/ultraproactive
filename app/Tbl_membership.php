<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership extends Model
{
	protected $table = 'tbl_membership';
	protected $primaryKey = 'membership_id';
	public $timestamps = false;
	protected $fillable = ['membership_name', 'membership_price','archived'];
	protected $guarded = ['membership_id'];




	

}

