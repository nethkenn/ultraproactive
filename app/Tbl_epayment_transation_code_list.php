<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_epayment_transation_code_list extends Model
{
	protected $table = 'tbl_epayment_transation_code_list';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['transaction_code', 'description','archived', 'front'];


	public function scopeGetFront($query)
	{
		return $query->where('front', 1)->where('archived', 0);
	}
}