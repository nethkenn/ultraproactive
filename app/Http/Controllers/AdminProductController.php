<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


// use Illuminate\Http\Request;
use DB;
use Request;
use Validator;
use Datatables;
// use App\Country;
use App\Tbl_product_category;
use App\Tbl_product;
use App\Classes\Image;
use Crypt;
class AdminProductController extends AdminController
{
	public function index()
	{

		$data["page"] = "Product Maintenance";
		
        return view('admin.maintenance.product');
	}

	public function add_product()
	{
		$data["page"] = "Add Product Maintenance";
		$data['_error'] = null;
		$data['_prod_cat'] = Tbl_product_category::where('archived',0)->count() > 0 ? Tbl_product_category::where('archived',0)->get() : null;

		// dd(Tbl_product_category::where('archived',0)->count());
		// $data['_prod_cat'] = null;
		if(isset($_POST['product_name']))
		{

			$rules['product_name'] = 'required|unique:tbl_product,product_name|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['sku'] = 'unique:tbl_product,sku|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['product_category'] = 'required|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['unilevel_pts'] = 'numeric|min:0';
			$rules['binary_pts'] = 'numeric|min:0';
			$rules['price'] = 'numeric|min:0';
			

			$message = [
				'product_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
				'product_category.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
				'sku.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )'
			];


			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{
				$product = new Tbl_product(Request::input());
				$product->product_category_id = $this->get_prod_cat(Request::input('product_category'));
				$product->sku = Request::input('sku');
				$product->save();
				return redirect('admin/maintenance/product');
			}
			else
			{
				$data['_error'] = $validator->errors()->all();
			}

			

		}
		


		
		


		
        return view('admin.maintenance.product_add',$data);
	}



	public function get_prod_cat($input)
	{

		$prod_cat = Tbl_product_category::where('product_category_name',$input)->first();
		if($prod_cat)
		{
			/**
			 * IF CATEGORY EXIST RETURN THE ID.
			 */
			 $prod_cat_id = $prod_cat->product_category_id;
		}
		else
		{

			/**
			 * IF CATEGORY DO NOT EXIST CREATRE NEW CATEGORY AND RETURN THE INSERT ID.
			 */
			$prod_cat = new Tbl_product_category;
			$prod_cat->product_category_name = $input;
			$prod_cat->save();
			$prod_cat_id = $prod_cat->product_category_id;
		}

		return $prod_cat_id;
	}

	public function ajax_get_product()
	{
		

		$product = Tbl_product::where('tbl_product.archived',Request::input('archived'))->leftJoin('tbl_product_category','tbl_product_category.product_category_id','=','tbl_product.product_category_id')->get();
		$text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
		$class = Request::input('archived') ? 'restore-product' : 'archive-product';
		
		
		// foreach ($_product as $key => $value) {
		// 	$product[$key] = $value;
		// 	$product[$key]->img_src = $value->main_image_src;
		// }


		// dd();
		// return $product;
		// foreach($_product as $key => $value)
		// {
		// 	$product[$key] = $value;
		// }
		
		// dd($product);
        return Datatables::of($product)	
        								->addColumn('edit','<a href="admin/maintenance/product/edit?id={{$product_id}}">EDIT</a>')
        								->editColumn('image_file','@if($image_file != "default.jpg")<a href="'.Image::get_path().'{{$image_file}}/{{$image_file}}" target="_blank">{{$image_file}}</a>@else{{$image_file}}@endif')
								        ->addColumn('archive','<a class="'.$class.'" href="#" product-id="{{$product_id}}">'.$text.'</a>')
								        ->make(true);
        
	}


	public function edit_product()
	{
		$id = Request::input('id');
		
		
		$data['product'] = Tbl_product::where('product_id',$id)->first();
		$data['product']->img_src = $data['product']->image_file == 'default.jpg' ? 'resources/assets/img/1428733091.jpg' : Image::view($data['product']->image_file, $size="250x250");
		// dd($data['product']);
		$data["page"] = "Add Product Maintenance";
		$data['_error'] = null;
		$data['_prod_cat'] = Tbl_product_category::where('archived',0)->get();



		if(isset($_POST['product_name']))
		{

			$rules['product_name'] = 'required|unique:tbl_product,product_name,'.$data['product']->product_id.',product_id|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['sku'] = 'unique:tbl_product,sku,'.$data['product']->product_id.',product_id|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['product_category'] = 'required|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['unilevel_pts'] = 'numeric|min:0';
			$rules['binary_pts'] = 'numeric|min:0';
			$rules['price'] = 'numeric|min:0';
			

			$message = [
				'product_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
				'product_category.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )'
			];


			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{

				// dd(Request::input());
				var_dump(Request::input());
				$product = Tbl_product::findOrFail(Request::input('product_id'));
				$product->product_category_id = $this->get_prod_cat(Request::input('product_category'));
				$product->sku = Request::input('sku');
				$product->update(Request::input());

				return redirect('admin/maintenance/product');
			}
			else
			{
				$data['_error'] = $validator->errors()->all();
			}

			

		}


		return view('admin.maintenance.product_edit',$data);
	}



	public function archive_product()
	{	

		$id = Request::input('id');
		$data['query'] = Tbl_product::where('product_id',$id)->update(['archived'=>'1']);

		return json_encode($data);
	}

	public function restore_product()
	{	

		$id = Request::input('id');
		$data['query'] = Tbl_product::where('product_id',$id)->update(['archived'=>'0']);

		return json_encode($data);
	}

}