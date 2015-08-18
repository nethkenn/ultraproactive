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
use App\Tbl_membership;
use App\Tbl_stockist;
use App\Tbl_stockist_inventory;
use App\Tbl_stockist_package_inventory;

class AdminProductPackageController extends AdminController
{
	public function index()
	{

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
			$insert[$ctr]['quantity'] = intval($value['quantity']) <= 0 ? 1 : intval($value['quantity']);
			$insert[$ctr]['product_package_id'] = $id;

			$ctr++;
		}

		Tbl_product_package_has::insert($insert);
	}

	public function add_product_package()
	{



		$data["page"] = "Add Package Maintenance";
		$data['_error'] = null;
		$data['membership'] = Tbl_membership::where('archived',0)->get();

		// if(isset($_POST['product_package_name']))
		// {
			



			// $rules['product_package_name'] = 'required|unique:tbl_product_package,product_package_name|regex:/^[A-Za-z0-9\s-_]+$/';
			// $rules['product'] = 'required';
			// $message['product_package_name.regex'] = 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )';
				
	

			// $validator = Validator::make(Request::input(),$rules,$message);
			
			// if (!$validator->fails())
			// {




		// 	}
		// 	else
		// 	{
		// 		$errors =  $validator->errors();
		// 		$data['_error']['product_package_name'] = $errors->get('product_package_name');
		// 		// $data['_error']['product'] = $errors->get('product');
		// 	}
		// 	return Redirect('admin/maintenance/product_package');
		// }

		


		
		


		
        return view('admin.maintenance.product_package_add',$data);
	}


	public function create_product_package()
	{

		// dd(Request::input());
		$request['product_package_name'] = Request::input('product_package_name');
		$request['membership_id'] = Request::input('membership_id');
		$request['product'] = Request::input('product');
		$rules['product_package_name'] = 'required|unique:tbl_product_package,product_package_name|regex:/^[A-Za-z0-9\s-_]+$/';
		$rules['membership_id'] = "required|exists:tbl_membership,membership_id";
		$rules['product'] = "required";
		$messages['product.required'] = "Package must have aleast 1 product.";
		if($request['product'] )
		{
			foreach ( $request['product'] as $key => $value)
			{
				$request['product_'.$key] = $key;
				$rules['product_'.$key] = 'integer|min:1|exists:tbl_product,product_id|prod_qty:'.$value['quantity'];
				$messages['product_'.$key.'.prod_qty'] = "The :attribute must have aleast 1 quanity.";
			}
		}




		Validator::extend('prod_qty', function($attribute, $value, $parameters) {
            return $parameters[0] > 0;
        });


		$validator = Validator::make($request, $rules, $messages);
        if ($validator->fails())
        {
            return redirect('admin/maintenance/product_package/add')
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }



		$product_package =  new Tbl_product_package;
		$product_package->product_package_name = Request::input('product_package_name');
		$product_package->membership_id = Request::input('membership_id');
		$product_package->save();
		$id = $product_package->product_package_id;
		$this->save_product_package($id, Request::input('product'));

		$stockist = Tbl_stockist::all();
        if($stockist)
        {
            foreach ($stockist as $key => $stockist)
            {
                $insert_stockist_inventory['stockist_id'] = $stockist->stockist_id;
                $insert_stockist_inventory['product_package_id'] = $id;

                $stockist_inventory = new Tbl_stockist_package_inventory($insert_stockist_inventory);
                $stockist_inventory->save();
            }
        }

		return Redirect('admin/maintenance/product_package');

	}






	public function edit_product_package()
	{


		$prod_package = Tbl_product_package::findOrFail(Request::input('id'));
		$data['prod_package'] = $prod_package;
		$prod_package_id = $prod_package->product_package_id;
		$data["page"] = "Edit Package Maintenance";
		$data['_error'] = null;
		$data['_product'] = Tbl_product_package_has::Product()->where('product_package_id',$prod_package_id)->get();
		$data['membership'] = Tbl_membership::where('archived',0)->get();
		// if(isset($_POST['product_package_name']))
		// {
			



		// 	$rules['product_package_name'] = 'required|unique:tbl_product_package,product_package_name,'.$prod_package_id.',product_package_id|regex:/^[A-Za-z0-9\s-_]+$/';
		// 	// $rules['product'] = 'numeric|min:1'; 

		// 				$message = [
		// 		'product_package_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
				
		// 	];

		// 	$validator = Validator::make(Request::input(),$rules,$message);
			
		// 	if (!$validator->fails())
		// 	{




			// }
			// else
			// {
			// 	$errors =  $validator->errors();
			// 	$data['_error']['product_package_name'] = $errors->get('product_package_name');
			// 	// $data['_error']['product'] = $errors->get('product');
			// }

		// }

		


		
		


		
        return view('admin.maintenance.product_package_edit',$data);
	}


	public function update_product_package()
	{	$request['product_package_id'] =  Request::input('product_package_id');
		$request['product_package_name'] = Request::input('product_package_name');
		$request['membership_id'] = Request::input('membership_id');
		$request['product'] = Request::input('product');

		$rules['product_package_id'] = 'exists:tbl_product_package,product_package_id';
		$rules['product_package_name'] = 'required|unique:tbl_product_package,product_package_name,'.$request['product_package_id'] .',product_package_id|regex:/^[A-Za-z0-9\s-_]+$/';
		$rules['membership_id'] = "required|exists:tbl_membership,membership_id";
		$rules['product'] = "required";
		$messages['product.required'] = "Package must have aleast 1 product.";

		if($request['product'] )
		{
			foreach ( $request['product'] as $key => $value)
			{
				$request['product_'.$key] = $key;
				$rules['product_'.$key] = 'integer|min:1|exists:tbl_product,product_id|prod_qty:'.$value['quantity'];
				$messages['product_'.$key.'.prod_qty'] = "The :attribute must have aleast 1 quanity.";
			}
		}


		Validator::extend('prod_qty', function($attribute, $value, $parameters) {
            return $parameters[0] > 0;
        });


		$validator = Validator::make($request, $rules, $messages);
        if ($validator->fails())
        {
            return redirect('admin/maintenance/product_package/edit?id='.Request::input('product_package_id'))
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }




		$product_package = Tbl_product_package::find(Request::input('product_package_id'));
		$product_package->product_package_name = Request::input('product_package_name');
		$product_package->membership_id = Request::input('membership_id');
		$product_package->save();
		$this->save_product_package(Request::input('product_package_id'), Request::input('product'));
		return Redirect('admin/maintenance/product_package');
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

	public function archive_product_package()
	{	

		// dd('lol');

		$id = Request::input('id');
		// dd($id);
		$data['query'] = Tbl_product_package::where('product_package_id',$id)->update(['archived'=>'1']);

		return json_encode($data);
	}

	public function restore_product_package()
	{	

		$id = Request::input('id');

		$data['query'] = Tbl_product_package::where('product_package_id',$id)->update(['archived'=>'0']);

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