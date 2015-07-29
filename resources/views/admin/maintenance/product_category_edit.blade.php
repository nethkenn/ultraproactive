@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-newspaper-o"></i> Edit Product Category</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/product_category'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/maintenance/product_category/edit_submit" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $product_category->product_category_id }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Category Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{ $product_category->product_category_name }}" required>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
