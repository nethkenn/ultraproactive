<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tbl_product_discount_stockist extends Model
{
	protected $table = 'tbl_product_discount_stockist';

    public function scopeProduct($query)
    {
        return $query->leftJoin("tbl_product", "tbl_product.product_id", "=", "tbl_product_discount_stockist.product_id");
    }

}
