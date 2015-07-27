<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_deduction extends Model
{
	protected $table = 'tbl_deduction';
	protected $primaryKey = 'deduction_id';
    public $timestamps = false;
	


    public function scopeCountry($query)
    {
        return $query->leftJoin('tbl_country','tbl_deduction.target_country','=','tbl_country.country_id');
    }

    public function scopeDeductionCountry($query)
    {
        return $query->join('tbl_deduction','tbl_deduction.deduction_id','=','rel_deduction_country.deduction_id');
    }




}