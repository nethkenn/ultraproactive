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
use App\Tbl_product_package;
use App\Tbl_product_package_has;
use App\Classes\Image;
use Crypt;

class AdminProductPackageController extends AdminController
{
	public function index()
	{


		// dd(Tbl_product_package::all());

		$data["page"] = "Product Package Maintenance";


		
        return view('admin.maintenance.product_package',$data);
	}


	public function save_product_package($id,$product)
	{
		Tbl_product_package_has::where('product_package_id',$id)->delete();
		$ctr=0;
		foreach($product as $key => $value)
		{
			$insert[$ctr]['product_id'] = $key;
			$insert[$ctr]['quantity'] = $value['quantity'];
			$insert[$ctr]['product_package_id'] = $id;

			$ctr++;
		}

		Tbl_product_package_has::insert($insert);
		// dd($insert);
	}

	public function add_product_package()
	{

		if(isset($_POST['product_package_name']))
		{
			
			$product_package =  new Tbl_product_package;
			$product_package->product_package_name = Request::input('product_package_name');
			$product_package->save();
			$id = $product_package->product_package_id;
			
			$this->save_product_package($id, Request::input('product'));




		}

		$data["page"] = "Add Package Maintenance";
		$data['_error'] = null;


		$_product = Tbl_product::where('tbl_product.archived',0)->leftJoin('tbl_product_category', 'tbl_product_category.product_category_id','=','tbl_product.product_category_id')->get();

		foreach ($_product as $key => $value)
		{
			$product[$key] = $value;	# code...
		}

		$data['product'] = $product;
		// dd($product);
		// $data['_prod_cat'] = Tbl_product_category::where('archived',0)->get();
		// if(isset($_POST['product_name']))
		// {



			// $rules['product_name'] = 'required|unique:tbl_product,product_name|regex:/^[A-Za-z0-9\s-_]+$/';
			// $rules['product_category'] = 'required|regex:/^[A-Za-z0-9\s-_]+$/';
			// $rules['unilevel_pts'] = 'numeric|min:0';
			// $rules['binary_pts'] = 'numeric|min:0';
			// $rules['price'] = 'numeric|min:0';
			

			// $message = [
			// 	'product_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
			// 	'product_category.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )'
			// ];


			// $validator = Validator::make(Request::input(),$rules,$message);
			
			// if (!$validator->fails())
			// {
			// 	$product = new Tbl_product(Request::input());
			// 	$product->product_category_id = $this->get_prod_cat(Request::input('product_category'));
			// 	$product->save();
			// 	return redirect('admin/maintenance/product');
			// }
			// else
			// {
			// 	$data['_error'] = $validator->errors()->all();
			// }

			

		// }
		


		
		


		
        return view('admin.maintenance.product_package_add',$data);
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

	public function ajax_get_product_package()
	{
		

		$product = Tbl_product_package::where('archived',Request::input('archived'));
		$text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
		$class = Request::input('archived') ? 'restore-product-package' : 'archive-product-package';
		
        return Datatables::of($product)	
        								->addColumn('edit','<a href="admin/maintenance/product_package/edit?id={{$product_package_id}}">EDIT</a>')
        								// ->editColumn('image_file','@if($image_file != "default.jpg")<a href="'.Image::get_path().'{{$image_file}}/{{$image_file}}" target="_blank">{{$image_file}}</a>@else{{$image_file}}@endif')
								        ->addColumn('archive','<a class="'.$class.'" href="#" product-package-id="{{$product_package_id}}">'.$text.'</a>')
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

				
				$product = Tbl_product::findOrFail(Request::input('product_id'));
				$product->product_category_id = $this->get_prod_cat(Request::input('product_category'));
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


	public function ajax_get_product()
	{
		

		$product = Tbl_product::where('tbl_product.archived',0)->leftJoin('tbl_product_category','tbl_product_category.product_category_id','=','tbl_product.product_category_id')->get();
        return Datatables::of($product)	
								        ->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
								        ->make(true);
        
	}

}