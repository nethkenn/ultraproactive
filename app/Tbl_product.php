<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Classes\Image;
use App\Classes\Product;
class Tbl_product extends Model implements SluggableInterface
{
	protected $table = 'tbl_product';
	protected $primaryKey = 'product_id';
	protected $fillable = ['product_name','product_discount','slug','product_category_id', 'unilevel_pts', 'binary_pts', 'price','image_file','barcode','product_info'];
	

    // protected $attributes = array(
    //     'main_image_src'
    // );


    use SluggableTrait;
    protected $sluggable = array(
	    'build_from'      => 'product_name',
	    'save_to'         => 'slug',
	    'max_length'      => null,
	    'method'          => null,
	    'separator'       => '-',
	    'unique'          => true,
	    'include_trashed' => false,
	    'on_update'       => true,
	    'reserved'        => null,
    );



    // public function getMainImageSrcAttribute()
    // {
    // 	$img_file = $this->image_file;

    // 	// return $img_file == 'default.jpg' || $img_file == '' || $img_file == null ? 'resources/assets/img/1428733091.jpg' : Image::view_main($img_file); 

    //     return $img_file;
    // }

	






    public function category()
    {
        return $this->hasOne('App\Tbl_product_category','product_category_id');
    }



    public function scopeActive($query)
    {
        return $query->where('archived', 0);
    }
   
    public function getImageFileAttribute($value)
    {

        // dd($value);
        if($value == "default.jpg" || $value == null)
        {
            $value =  '/resources/assets/img/1428733091.jpg';
        }
        else
        {
            $value = Image::view($value, "250x250");
        }



        return $value;
    }
}
