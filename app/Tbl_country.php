<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_country extends Model
{
	protected $table = 'tbl_country';
	protected $primaryKey = 'country_id';


	public function scopeDeduct($query)
    {
        return $query->join("tbl_deduction", "tbl_country.country_id", "=", "tbl_deduction.target_country");
    }

    public function scopeDeductionCountry($query)
    {
        return $query->join("rel_deduction_country", "rel_deduction_country.country_id", "=", "tbl_country.country_id");
    }
    public function scopeDeduct2($query)
    {
        return $query->join('rel_deduction_country','rel_deduction_country.country_id','=','tbl_country.country_id');
    }

    public function scopeDeductionCountry2($query)
    {
        return $query->join('tbl_deduction','tbl_deduction.deduction_id','=','rel_deduction_country.deduction_id');
    }
}