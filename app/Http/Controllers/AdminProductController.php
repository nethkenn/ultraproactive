<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tbl_stockist_inventory;
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
use App\Tbl_stockist;
use App\Tbl_stockist_package_inventory;
use App\Classes\Log;
use App\Classes\Admin;
use Carbon\Carbon;
class AdminProductController extends AdminController
{
	public function index()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Product");
		$data["page"] = "Product Maintenance";
		// 
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
			$rules['upgrade_pts'] = 'numeric|min:0';
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
				$product->upgrade_pts = Request::input('upgrade_pts');
				// $product->product_discount = Request::input('product_discount');
				$product->save();
				$new = DB::table('tbl_product')->where('product_id',$product->product_id)->first();
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add new product called ".$product->product_name." id #".$product->product_id,null,serialize($new));

				$stockist = Tbl_stockist::all();
		        if($stockist)
		        {
		            foreach ($stockist as $key => $stockist)
		            {
		                $insert_stockist_inventory['stockist_id'] = $stockist->stockist_id;
		                $insert_stockist_inventory['product_id'] = $product->product_id;

		                $stockist_inventory = new Tbl_stockist_inventory($insert_stockist_inventory);
		                $stockist_inventory->save();

		                
		            }
		        }

				return redirect('admin/maintenance/product');
			}
			else
			{
				$data['_error'] = $validator->errors()->all();
			}

			

		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Product");
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
			$rules['upgrade_pts'] = 'numeric|min:0';
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
				$old = DB::table('tbl_product')->where('product_id',Request::input('product_id'))->first();
				$product = Tbl_product::findOrFail(Request::input('product_id'));
				$product->product_category_id = $this->get_prod_cat(Request::input('product_category'));
				$product->price = Request::input('price');
				$product->product_info = Request::input('product_info');
				$product->product_name = Request::input('product_name');
				$product->unilevel_pts = Request::input('unilevel_pts');
				// $product->product_discount = Request::input('product_discount');
				$product->binary_pts = Request::input('binary_pts');
				$product->upgrade_pts = Request::input('upgrade_pts');
				$product->image_file = Request::input('image_file');
				$product->sku = Request::input('sku');
				$product->save();
				$new = DB::table('tbl_product')->where('product_id',$product->product_id)->first();

				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit the product id #".$product->product_id,serialize($old),serialize($new));
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
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive id #".Request::input('id'));
		$data['query'] = Tbl_product::where('product_id',$id)->update(['archived'=>'1']);
		Tbl_stockist_inventory::where('product_id',$id)->update(['archived'=>'1']);
		return json_encode($data);
	}

	public function restore_product()
	{	

		$id = Request::input('id');
		$data['query'] = Tbl_product::where('product_id',$id)->update(['archived'=>'0']);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." restore id #".Request::input('id'));
		Tbl_stockist_inventory::where('product_id',$id)->update(['archived'=>'0']);
		return json_encode($data);
	}

}