<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_voucher_has_product extends Model
{
	protected $table = 'tbl_voucher_has_product';
    protected $primaryKey = 'voucher_item_id';
    protected $fillable = ['product_id', 'voucher_id', 'price' , 'qty' , 'sub_total', 'binary_pts','unilevel_pts' ];

    public $timestamps = false;


    public function scopeProduct($query)
    {
    	return $query->leftJoin('tbl_product','tbl_product.product_id', '=', 'tbl_voucher_has_product.product_id');
    }

        public function scopeProductcode($query)
    {
        return $query->Join('tbl_product_code','tbl_product.product_id', '=', 'tbl_voucher_has_product.product_id');
    }


    public function getPriceAttribute($value)
    {
        return number_format($value, '2','.',',');
    }

    public function getSubTotalAttribute($value)
    {
        return number_format($value, '2','.',',');
    }

    public function scopeVoucher($query)
    {
        return $query->leftJoin('tbl_voucher','tbl_voucher.voucher_id', '=', 'tbl_voucher_has_product.voucher_id');
    }

    public function scopeAccount($query)
    {
        return $query->leftJoin('tbl_account','tbl_account.account_id', '=', 'tbl_voucher.account_id');
    }

}
