@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Binary / Modify Pairing Combination</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/rank'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-12">
                <label for="account_name">Promotion Requirements</label>
                <input name="membership_required_upgrade" value="{{ $data->membership_required_upgrade }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-12">
                <label for="account_meail">Allow Promotion</label>
                <select name="upgrade_via_points" class="form-control">
                	<option {{ $data->upgrade_via_points == 1 ? 'selected' : '' }} value="1">Enabled</option>
                	<option {{ $data->upgrade_via_points == 0 ? 'selected' : '' }} value="0">Disabled</option>
                </select>
            </div>
        </form>
    </div>
@endsection