<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_voucher extends Model
{
	protected $table = 'tbl_voucher';
	protected $primaryKey = 'voucher_id';
    protected $fillable = ['slot_id', 'voucher_code', 'claimed' , 'total_amount' , 'account_id'];



    public function product()
    {
        return $this->belongsToMany('App\Tbl_product', 'tbl_voucher_has_product', 'voucher_id', 'product_id');
    }
}
