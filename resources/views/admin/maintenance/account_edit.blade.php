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
                            @if($errors->get('account_name'))
                <div class="alert alert-danger">
                    <ul class="">
                        @foreach ($errors->get('account_name') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <input name="account_name" value="{{Request::old('account_name') ? Request::old('account_name') : $account->account_name }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="account_meail">Email</label>
                            @if($errors->get('account_meail'))
                <div class="alert alert-danger">
                    <ul class="">
                        @foreach ($errors->get('account_meail') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <input name="account_meail" value="{{ Request::old('account_meail')  ? Request::old('account_meail') : $account->account_email }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="account_contact">Contact Number</label>
                                            @if($errors->get('account_contact'))
                <div class="alert alert-danger">
                    <ul class="">
                        @foreach ($errors->get('account_contact') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <input name="account_contact" value="{{Request::old('account_contact')  ? Request::old('account_contact') :  $account->account_contact_number }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="country">Country</label>
                                                            @if($errors->get('country'))
                <div class="alert alert-danger">
                    <ul class="">
                        @foreach ($errors->get('country') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <select class="form-control" name="country">
                    @foreach($_country as $country)
                    <option {{ Request::old('country') || $country->country_id == $account->account_country_id ? 'selected="selected"' : '' }} value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="account_username">Username</label>
                                                                            @if($errors->get('account_username'))
                <div class="alert alert-danger">
                    <ul class="">
                        @foreach ($errors->get('account_username') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <input name="account_username" value="{{ Request::old('account_username') ? Request::old('account_username') : $account->account_username }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="account_password">Password</label>
                                                                                            @if($errors->get('account_password'))
                <div class="alert alert-danger">
                    <ul class="">
                        @foreach ($errors->get('account_password') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <input name="account_password" value="{{Crypt::decrypt($account->account_password) }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            @foreach($_account_field as $field)
            <div class="form-group col-md-6">
                <label for="custom_field">{{ $field->account_field_label }}</label>
                @if($errors->get('custom_field['.$field->account_field_label.']'))
                    <div class="alert alert-danger">
                        <ul class="">
                            @foreach ($errors->get('custom_field['.$field->account_field_label.']') as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input name="custom_field[{{ $field->account_field_label }}]" value="{{Request::old('custom_field')[$field->account_field_label] ? Request::old('custom_field')[$field->account_field_label]:  $_account_custom[$field->account_field_label]}}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            @endforeach
        </form>
    </div>
@endsection