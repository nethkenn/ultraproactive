@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-storiespaper-o"></i> Add Stories</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/stories'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/stories/add_submit" method="post">
            <div class="form-group col-md-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Stories Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="link" class="col-sm-2 control-label">Stories Link</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="link" name="link" required>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Stories Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                </div> 
            </div>
        </form>
    </div>
@endsection