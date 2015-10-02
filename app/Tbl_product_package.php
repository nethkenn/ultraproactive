<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tbl_product_package extends Model implements SluggableInterface
{
	protected $table = 'tbl_product_package';
	protected $primaryKey = 'product_package_id';
	public $timestamps = false;
	protected $fillable = ['product_package_name', 'archived'];
	protected $guarded = ['product_package_id'];
	

	use SluggableTrait;

    protected $sluggable = array(
	    'build_from'      => 'product_package_name',
	    'save_to'         => 'slug',
	    'max_length'      => null,
	    'method'          => null,
	    'separator'       => '-',
	    'unique'          => true,
	    'include_trashed' => false,
	    'on_update'       => true,
	    'reserved'        => null,
    );

	public function scopeActive($query)
    {
        return $query->where('archived', 0);
    }

}
