<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tbl_product_discount extends Model
{
	protected $table = 'tbl_product_discount';

    public function scopeProduct($query)
    {
        return $query->leftJoin("tbl_product", "tbl_product.product_id", "=", "tbl_product_discount.product_id");
    }

}
