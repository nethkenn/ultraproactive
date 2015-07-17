<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_voucher_has_product extends Model
{
	protected $table = 'tbl_voucher_has_product';
    protected $fillable = ['product_id', 'voucher_id', 'price' , 'qty' , 'sub_total' ];

    public $timestamps = false;

}
