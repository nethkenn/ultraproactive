@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-user-plus"></i> Add Partner</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/partner'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/partner/edit_submit" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $partner->partner_id }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Partner Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{ $partner->partner_title }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="link" class="col-sm-2 control-label">Partner Link</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="link" name="link" required value="{{ $partner->partner_link }}">
                    </div>
                </div>
            </div>
             <div class="form-group col-md-4 text-center">
                <label for="p-tags">Partner Image</label>
                <div class="primia-gallery main-image" target_input=".feature-image-input" target_image=".feature-image-img">
                    <img class="feature-image-img" src="{{ $partner->image }}">
                    <input type="text" class="feature-image-input text-center top-space-small borderless" name="image_file" value="{{ $partner->partner_image }}">
                </div>
            </div>
        </form>
    </div>
@endsection