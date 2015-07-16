@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Add Levels</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/position'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="country-add-form" class="form-horizontal" action="" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">

                <label for="inputEmail3" class="col-sm-2 control-label">Position Name</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="admin_position_name" value="{{Session::get('_old_input')['admin_position_name']}}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Position Level</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="level" name="admin_position_rank" value="{{Session::get('_old_input')['admin_position_rank']}}" required>
                </div>
            </div> 
            <div class="form-group">
                <label for="Modules" class="col-sm-2 control-label">Modules</label>
                <div class="col-sm-10">
                    @foreach($_module as $module)
                    <div class="col-md-6">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="module[]" value="{{$module->module_id}}" {{in_array($module->module_id, (array)Session::get('_old_input')['module']) ? 'selected' : '' }}>{{$module->module_name}}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
@endsection