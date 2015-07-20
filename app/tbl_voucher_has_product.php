<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_voucher_has_product extends Model
{
	protected $table = 'tbl_voucher_has_product';
    protected $fillable = ['product_id', 'voucher_id', 'price' , 'qty' , 'sub_total' ];

    public $timestamps = false;


    public function scopeProduct($query)
    {
    	return $query->leftJoin('tbl_product','tbl_product.product_id', '=', 'tbl_voucher_has_product.product_id');
    }


    public function getPriceAttribute($value)
    {
        return number_format($value, '2','.',',');
    }

    public function getSubTotalAttribute($value)
    {
        return number_format($value, '2','.',',');
    }




}
