<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_transaction_profile_input extends Model
{
    protected $table = 'tbl_transaction_profile_input';
	public $timestamps = false ;
	protected $fillable = [
							'profile_id',
							'input_id',
							'value'
						];


	public function scopeGetInput($query)
    {
        return $query->leftJoin('tbl_get_input','tbl_get_input.id','=', 'tbl_transaction_profile_input.input_id');
    }
}
