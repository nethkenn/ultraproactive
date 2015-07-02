<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tbl_rank extends Model implements SluggableInterface
{
	protected $table = 'tbl_rank';
	protected $primaryKey = 'rank_id';
	public $timestamps = false;
	protected $fillable = ['rank_name', 'rank_level'];
	protected $guarded = ['rank_id'];

	use SluggableTrait;

    protected $sluggable = array(
	    'build_from'      => 'rank_name',
	    'save_to'         => 'slug',
	    'max_length'      => null,
	    'method'          => null,
	    'separator'       => '-',
	    'unique'          => true,
	    'include_trashed' => false,
	    'on_update'       => true,
	    'reserved'        => null,
    );
}