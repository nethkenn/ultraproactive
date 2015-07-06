@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-newspaper-o"></i> Add Earn</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/maintenance/earn'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/maintenance/earn/add_submit" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Earn Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Earn Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
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