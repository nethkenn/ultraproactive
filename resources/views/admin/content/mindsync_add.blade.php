@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-newspaper-o"></i> Add Mindsync</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/mindsync'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/mindsync/add_submit" method="post">
            <div class="form-group col-md-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">MindSync Testimony</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="video" class="col-sm-2 control-label">MindSync Video</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="video" name="video" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">MindSync Sub Testimony</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div> 
            </div>
            <div class="form-group col-md-12 text-center row">
                <div class="holder col-md-3">
                    <label for="p-tags">MindSync Image 1</label>
                    <div class="primia-gallery main-image" target_input=".feature-image-input1" target_image=".feature-image-img1">
                        <img class="feature-image-img1" src="resources/assets/img/1428733091.jpg">
                        <input type="text" class="feature-image-input1 text-center top-space-small borderless" name="image_file[]" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                    </div>
                </div>
                <div class="holder col-md-3">
                    <label for="p-tags">MindSync Image 2</label>
                    <div class="primia-gallery main-image" target_input=".feature-image-input2" target_image=".feature-image-img2">
                        <img class="feature-image-img2" src="resources/assets/img/1428733091.jpg">
                        <input type="text" class="feature-image-input2 text-center top-space-small borderless" name="image_file[]" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                    </div>
                </div>
                <div class="holder col-md-3">
                    <label for="p-tags">MindSync Image 3</label>
                    <div class="primia-gallery main-image" target_input=".feature-image-input3" target_image=".feature-image-img3">
                        <img class="feature-image-img3" src="resources/assets/img/1428733091.jpg">
                        <input type="text" class="feature-image-input3 text-center top-space-small borderless" name="image_file[]" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                    </div>
                </div>
                <div class="holder col-md-3">
                    <label for="p-tags">MindSync Image 4</label>
                    <div class="primia-gallery main-image" target_input=".feature-image-input4" target_image=".feature-image-img4">
                        <img class="feature-image-img4" src="resources/assets/img/1428733091.jpg">
                        <input type="text" class="feature-image-input4 text-center top-space-small borderless" name="image_file[]" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection