<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_exchange_rate extends Model
{
	protected $table = 'tbl_exchange_rate';
	/**
	 * NO PRIMARY
	 */
	protected $primaryKey = 'country_id';
	protected $fillable = [
							'country_id',
							'peso_rate',
							'archived',
	 						];


	public $timestamps = false;


	public function scopeGetCurrency($query)
    {
        return $query->leftJoin('tbl_country', 'tbl_country.country_id','=', 'tbl_exchange_rate.country_id');
    }

}