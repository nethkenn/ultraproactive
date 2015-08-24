@extends('admin.layout')
@section('content')
@if($category == "video")
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add Video</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/content/mindsync/video'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" action="admin/content/mindsync/video/add_submit" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="video" class="col-sm-2 control-label">MindSync Video</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="video" name="video" required>
                </div>
            </div>
        </div>
    </form>
</div>
@endif
@if($category == "image")
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add Image</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/content/mindsync/image'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" action="admin/content/mindsync/image/add_submit" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group col-md-12 text-center row">
            <div class="holder col-md-3 col-md-offset-5">
                <label for="p-tags">MindSync Image</label>
                <div class="primia-gallery main-image" target_input=".feature-image-input" target_image=".feature-image-img">
                    <img class="feature-image-img" src="resources/assets/img/1428733091.jpg">
                    <input type="text" class="feature-image-input text-center top-space-small borderless" name="image_file" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                </div>
            </div>
        </div>
    </form>
</div>
@endif
@if($category == "testimony")
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add Testimony</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/content/mindsync/testimony'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" action="admin/content/mindsync/testimony/add_submit" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Person Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Person Testimony</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
            </div> 
        </div>
    </form>
</div>
@endif
@endsection