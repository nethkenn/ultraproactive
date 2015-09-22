@extends('admin.layout')
@section('content')

	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Add Edit Product</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/product/'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#product-edit-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>

    @if($_error)
        <div class="col-md-12 alert alert-danger form-errors">
            <ul>
                @foreach($_error as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-12 form-group-container">
        <form id="product-edit-form" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="product_id" value="{{$product->product_id}}">
                <div class="form-group col-md-12">
            		<label for="product_name">Product Name</label>
            		<input name="product_name" value="{{Request::input('product_name') ? Request::input('product_name') : $product->product_name}}" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>
                <div class="form-group col-md-12">
                    <label for="product_info">Product Description</label>
                     <textarea class="form-control" name="product_info">{{Request::input('product_info') ? Request::input('product_info') : $product->product_info}}</textarea>

                </div>
                    <div class="form-group col-md-12">
                    <label for="sku">SKU</label>
                    <input name="sku" value="{{Request::input('sku') ? Request::input('sku') : $product->sku}}" required="required" class="form-control" id="" placeholder="" type="text">
                </div>
                <div class="form-group col-md-12">
                    <label for="product_category">Product Category</label>
                    @if($_prod_cat)
                        <select id="prod_cat_input" class="form-control" name="product_category">
                            @foreach($_prod_cat as $prod_cat)
                                <option value="{{$prod_cat->product_category_name}}" {{$selected = Request::input('product_category') == $prod_cat->product_category_name || $prod_cat->product_category_id == $product->product_category_id ? 'selected="seleted"' : '' }}>{{$prod_cat->product_category_name}}</option>
                            @endforeach
                                <option id="" value="_add_new">Add New</option>
                        </select>
                    @else
                        <input id="prod_cat_input" name="product_category" value="{{Request::input('product_category') ? Request::input('product_category') : '' }}" required="required" class="form-control" id="" placeholder="Add new Product Category" type="text">
                    @endif
                </div>


            	<div class="form-group col-md-12">
            		<label for="unilevel_pts">Unilevel PTS</label>
            		<input name="unilevel_pts" value="{{Request::input('unilevel_pts') ? Request::input('unilevel_pts') : $product->unilevel_pts}}" required="required" class="form-control" id="" placeholder="" type="number">
            	</div>
            	<div class="form-group col-md-12">
            		<label for="binary_pts">Binary PTS</label>
            		<input name="binary_pts" value="{{Request::input('binary_pts') ? Request::input('binary_pts') : $product->binary_pts}}" required="required" class="form-control" id="" placeholder="" type="number">
            	</div>   
                <div class="form-group col-md-12">
                    <label for="upgrade_pts">Upgrade PTS</label>
                    <input name="upgrade_pts" value="{{Request::input('upgrade_pts') ? Request::input('upgrade_pts') : $product->upgrade_pts}}" required="required" class="form-control" id="" placeholder="" type="number">
                </div>   
                <div class="form-group col-md-12">
                    <label for="price">Price</label>
                    <input name="price" value="{{Request::input('price') ? Request::input('price') : $product->price}}" required="required" class="form-control" id="" placeholder="" type="number">
                </div>                

            </div>

            <div class="form-group col-md-4 text-center">
                <label for="p-tags">Product Image</label>
                <div class="primia-gallery main-image" target_input=".feature-image-input" target_image=".feature-image-img">
                    <img class="feature-image-img" src="{{$product->img_src}}">
                    {{-- resources/assets/img/1428733091.jpg --}}
                    <input type="text" class="feature-image-input text-center top-space-small borderless" name="image_file" value="{{Request::input('image_file') ? Request::input('image_file') : $product->image_file}}">
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $('#prod_cat_input').on('change', function(event)
    {   var tag_name = this.tagName.toLowerCase();
        if(tag_name == 'select')
        {
            var e = document.getElementById("prod_cat_input");
            var tag_name_val = e.options[e.selectedIndex].value;
            if(tag_name_val=='_add_new')
            {
                $(this).replaceWith('<input id="prod_cat_input" name="product_category" value="" required="required" class="form-control" id="" placeholder="Add new Product Category" type="text">');
            }
        }
        
    });

</script>
@endsection