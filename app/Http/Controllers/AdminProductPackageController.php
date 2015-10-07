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
use App\Classes\Log;
use App\Classes\Admin;
class AdminProductPackageController extends AdminController
{
	public function index()
	{

		$data["page"] = "Product Package Maintenance";
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Product Package Maintenance");

		
        return view('admin.maintenance.product_package',$data);
	}


	public function save_product_package($id,$product,$method)
	{
		$old = DB::table('tbl_product_package_has')->where('product_package_id',$id)->get();
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

		$new = DB::table('tbl_product_package_has')->where('product_package_id',$id)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." ".$method." Product Package Id #".$id,serialize($old),serialize($new));
	}

	public function add_product_package()
	{



		$data["page"] = "Add Package Maintenance";
		$data['_error'] = null;
		$data['membership'] = Tbl_membership::where('archived',0)->where('membership_entry',1)->get();

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
		$this->save_product_package($id, Request::input('product'),"Add");

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
		$data['membership'] = Tbl_membership::where('archived',0)->where('membership_entry',1)->get();
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
		$this->save_product_package(Request::input('product_package_id'), Request::input('product'),"Edit");
		return Redirect('admin/maintenance/product_package');
	}
	public function ajax_get_product_package()
	{
		

		$product = Tbl_product_package::leftJoin('tbl_membership', 'tbl_product_package.membership_id', '=', 'tbl_membership.membership_id')->where('tbl_product_package.archived',Request::input('archived'))->get();
		$text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
		$class = Request::input('archived') ? 'restore-product-package' : 'archive-product-package';
		
        return Datatables::of($product)	
        								->addColumn('edit','<a href="admin/maintenance/product_package/edit?id={{$product_package_id}}">EDIT</a>')
        								// ->editColumn('image_file','@if($image_file != "default.jpg")<a href="'.Image::get_path().'{{$image_file}}/{{$image_file}}" target="_blank">{{$image_file}}</a>@else{{$image_file}}@endif')
        								->editColumn('linked','<a id="view_content" href="/admin/maintenance/product_package#view_content" package-id="{{$product_package_id}}">{{$product_package_name}}</a>')
        								->editColumn('membership','{{ $membership_name }}')
								        ->addColumn('archive','<a class="'.$class.'" href="#" product-package-id="{{$product_package_id}}">'.$text.'</a>')
								        ->make(true);
        
	}

	public function archive_product_package()
	{	

		// dd('lol');

		$id = Request::input('id');
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive Product Package Id #".$id);
		$data['query'] = Tbl_product_package::where('product_package_id',$id)->update(['archived'=>'1']);

		return json_encode($data);
	}

	public function restore_product_package()
	{	

		$id = Request::input('id');
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." restore Product Package Id #".$id);
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
	public function view_content()
	{
		if( $_REQUEST["id"] )
		{
		   $id = $_REQUEST['id'];
		   // $data = DB::table("tbl_product_package")->where("product_package_id", $id)->first();
		   $package_has = DB::table("tbl_product_package_has")->where("product_package_id", $id)->get();
		   foreach ($package_has as $key => $value) 
		   {
		   		$product = DB::table("tbl_product")->where("product_id", $value->product_id)->first();
		   		$products[] = $product;
		   }  
		   // dd($products);
		   echo json_encode($products);
		}
	}
}