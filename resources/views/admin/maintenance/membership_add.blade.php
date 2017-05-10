@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Add New membership</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/membership'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#membership-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="membership-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                    <label for="membership_name">Membership Name</label>
                    @if($_error['membership_name'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_name'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            		<input name="membership_name" value="{{Request::input('membership_name')}}" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>
            	<div class="form-group col-md-6">
                    <label for="membership_price">Membership Price</label>
                    @if($_error['membership_price'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_price'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            		<input name="membership_price" value="{{Request::input('membership_price')}}" required="required" class="form-control" id="" placeholder="" type="number">
            	</div>
            	<div class="form-group col-md-6">
                    <label for="direct_income_limit">Direct Income Limit</label>
                    @if($_error['direct_income_limit'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['direct_income_limit'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            		<input name="direct_income_limit" value="10000" required="required" class="form-control" id="" placeholder="" type="number" value="10000">
            	</div>
                <div class="form-group col-md-6">
                    <label for="global_pool_sharing">Global Pool Sharing (0-100%)</label>
                    @if($_error['global_pool_sharing'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['global_pool_sharing'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input name="global_pool_sharing" value="{{Request::input('global_pool_sharing')}}" required="required" class="form-control" id="" placeholder="" type="number">
                </div>

                <div class="form-group col-md-6">
                    <label for="max_group_pv">Max Group PV for sharing</label>
                    @if($_error['max_group_pv'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['max_group_pv'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input name="max_group_pv" value="{{Request::input('max_group_pv')}}" required="required" class="form-control" id="" placeholder="" type="number">
                </div>

                <div class="form-group col-md-6">
                    <label for="discount">Enable Entry</label>
                    @if($_error['membership_entry'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_entry'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="membership_entry" class="form-control">
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select>
                </div> 

                <div class="form-group col-md-6">
                    <label for="discount">Enable Upgrade</label>
                    @if($_error['membership_upgrade'])
                        <div class="col-md-12 alert alert-danger form-errors">
                            <ul>
                                @foreach($_error['membership_upgrade'] as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <select name="membership_upgrade" class="form-control">
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select>
                </div>  
        </form>
    </div>
@endsection