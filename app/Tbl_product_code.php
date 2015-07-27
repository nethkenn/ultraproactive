<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_product_code extends Model
{
	protected $table = 'tbl_product_code';
	protected $primaryKey = 'product_pin';
	protected $fillable = [

                            'code_activation',
							'voucher_item_id',
							'log_id',
							'used',
							'lock',
							'archived',
	 						];

    public function scopeVoucher($query)
    {
        return $query	->leftJoin("tbl_voucher_has_product", "tbl_voucher_has_product.voucher_item_id", "=", "tbl_product_code.voucher_item_id")
        				->leftJoin("tbl_voucher", "tbl_voucher.voucher_id", "=", "tbl_voucher_has_product.voucher_id");
    }				
    public function scopeProduct($query)
    {
        return $query	->leftJoin("tbl_product", "tbl_product.product_id", "=", "tbl_voucher_has_product.product_id");
    }
    public function scopeUnused($query)
    {
       return $query->where("used", 0);
    }

}

