@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-book"></i> Add Testimony</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/testimony'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/testimony/add_submit" method="post">
            <div class="form-group col-md-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="text" class="col-sm-2 control-label">Testimony Text</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="text" name="text" required></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                    <label for="person" class="col-sm-2 control-label">Testimony Person</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="person" name="person" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                    <label for="position" class="col-sm-2 control-label">Testimony Position</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection