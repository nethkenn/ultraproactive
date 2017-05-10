<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tbl_package_discount_stockist extends Model
{
	protected $table = 'tbl_package_discount_stockist';

    public function scopeProduct($query)
    {
        return $query->leftJoin("tbl_product_package", "tbl_product_package.product_package_id", "=", "tbl_package_discount_stockist.product_package_id");
    }

}
