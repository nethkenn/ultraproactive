@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-sliders"></i> Add Slide</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/slide'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/slide/add_submit" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Slide Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
            </div>
             <div class="form-group col-md-4 text-center">
                <label for="p-tags">Slide Image</label>
                <div class="primia-gallery main-image" target_input=".feature-image-input" target_image=".feature-image-img">
                    <img class="feature-image-img" src="resources/assets/img/1428733091.jpg">
                    <input type="text" class="feature-image-input text-center top-space-small borderless" name="image_file" value="{{Request::input('image_file') ? Request::input('image_file') : 'default.jpg'}}">
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
    <script>tinymce.init({
        selector:'textarea',
        toolbar: "undo redo | bold italic",
        menubar: "view edit",
        force_br_newlines : true,
        force_p_newlines : false
    });</script>
@endsection