@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i> Account / Modify</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/maintenance/accounts'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-6">
                <label for="account_name">Full Name</label>
                <input name="account_name" value="{{ $account->account_name }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="account_meail">Email</label>
                <input name="account_meail" value="{{ $account->account_email }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="account_contact">Contact Number</label>
                <input name="account_contact" value="{{ $account->account_contact_number }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="country">Country</label>
                <select class="form-control" name="country">
                    @foreach($_country as $country)
                    <option {{ $country->country_id == $account->account_country_id ? 'selected="selected"' : '' }} value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                    @endforeach
                </select>
            </div>

            @foreach($_account_field as $field)
            <div class="form-group col-md-6">
                <label for="custom_field">{{ $field->account_field_label }}</label>
                <input name="custom_field[{{ $field->account_field_label }}]" value="{{ isset($_account_custom[$field->account_field_label]) ? $_account_custom[$field->account_field_label] : '' }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            @endforeach
        </form>
    </div>
@endsection