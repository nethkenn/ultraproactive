@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-servicepaper-o"></i> Add Service</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/service'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/service/edit_submit" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $service->service_id }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Service Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{ $service->service_title }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Service Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description">{{ $service->service_description }}</textarea>
                    </div>
                </div> 
            </div>
             <div class="form-group col-md-4 text-center">
                <label for="p-tags">Service Image</label>
                <div class="primia-gallery main-image" target_input=".feature-image-input" target_image=".feature-image-img">
                    <img class="feature-image-img" src="{{ $service->image }}">
                    <input type="text" class="feature-image-input text-center top-space-small borderless" name="image_file" value="{{ $service->service_image }}">
                </div>
            </div>
        </form>
    </div>
@endsection