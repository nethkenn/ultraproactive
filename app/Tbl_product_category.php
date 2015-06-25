<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tbl_product_category extends Model implements SluggableInterface
{
	protected $table = 'tbl_product_category';
	protected $primaryKey = 'product_category_id';
	protected $fillable = ['product_category_name', 'slug'];


	



	use SluggableTrait;

    protected $sluggable = array(
	    'build_from'      => 'product_category_name',
	    'save_to'         => 'slug',
	    'max_length'      => null,
	    'method'          => null,
	    'separator'       => '-',
	    'unique'          => true,
	    'include_trashed' => false,
	    'on_update'       => true,
	    'reserved'        => null,
    );


   public function product()
	{
	    return $this->belongsTo('App\Tbl_product','product_id');
	}
}
