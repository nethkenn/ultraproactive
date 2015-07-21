<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tbl_voucher extends Model
{
	protected $table = 'tbl_voucher';
	protected $primaryKey = 'voucher_id';
    protected $fillable = ['slot_id', 'voucher_code', 'claimed' , 'total_amount' , 'account_id'];

   	// protected $dates = ['created_at', 'updated_at'];
    // protected $dateFormat = 'Y-m-d';
    public function product()
    {
        return $this->belongsToMany('App\Tbl_product', 'tbl_voucher_has_product', 'voucher_id', 'product_id');
    }


    public function getTotalAmountAttribute($value)
    {
        return number_format($value, '2','.',',');
    }

    public function getCreatedAtAttribute($value)
    {
    	$carbon = new Carbon($value);
    	return $carbon->format('F, d Y');
        // return $carbon->toDayDateTimeString();s
    }


    public function getUpdatedAtAttribute($value)
    {
        $carbon = new Carbon($value);
        // return $carbon->format('F, d Y');
        return $carbon->toDayDateTimeString();
    }


    // public function getStatusAttribute($value)
    // {
    //     return ucfirst($value);
    // }


}
