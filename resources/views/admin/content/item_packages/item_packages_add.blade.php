@extends('admin.layout')
@section('content')
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add Item Packages</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='/admin/content/item_packages'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" action="{{$action}}" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="item_packages_id" value="{{$item_packages->item_package_id or ''}}" >
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Package Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="item_packages_title" value="{{$item_packages->item_package_title or ''}}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-10">
                    <div class="primia-gallery main-image" target_input=".feature-image-input" target_image=".feature-image-img">
                        <img class="feature-image-img" src="{{$item_packages->item_package_image or 'resources/assets/img/1428733091.jpg' }}">
                        <input type="text" class="feature-image-input text-center top-space-small borderless" name="image_file" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                    </div>
                </div>
            </div> 
        </div>
    </form>
</div>
@endsection