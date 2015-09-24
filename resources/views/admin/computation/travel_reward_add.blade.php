@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Add Reward</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/travel_reward'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Add</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-6">
                <label for="account_name">Reward Name</label>
                @if($_error['travel_reward_name'])
                    <div class="col-md-12 alert alert-danger form-errors">
                        <ul>
                            @foreach($_error['travel_reward_name'] as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input name="travel_reward_name" value="" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-6">
                <label for="account_meail">Required Points </label>
                @if($_error['required_points'])
                    <div class="col-md-12 alert alert-danger form-errors">
                        <ul>
                            @foreach($_error['required_points'] as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input name="required_points" value="" required="required" class="form-control" id="" placeholder="" type="text">
            </div>   
        </form>
    </div>
@endsection