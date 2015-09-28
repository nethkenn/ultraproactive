@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Edit Qualification</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/travel_qualification'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-6">
                <label for="account_name">Qualification Category</label>
                @if($_error['travel_qualification_name'])
                    <div class="col-md-12 alert alert-danger form-errors">
                        <ul>
                            @foreach($_error['travel_qualification_name'] as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <select class="form-control" name="travel_qualification_name">
                    <option value="Direct Referral" {{$data->travel_qualification_name == "Direct Referral" ?  "selected" : ""}}>Direct Referral</option>
                    <option value="Total Income" {{$data->travel_qualification_name == "Total Income" ?  "selected" : ""}}>Total Income</option>
                    <option value="Total Spent" {{$data->travel_qualification_name == "Total Spent" ?  "selected" : ""}}>Total Spent</option>
                    <option value="Total Downline" {{$data->travel_qualification_name == "Total Downline" ?  "selected" : ""}}>Total Downline</option>
                </select> 
            </div>  
            <div class="form-group col-md-6">
                <label for="account_meail">Item </label>
                @if($_error['item'])
                    <div class="col-md-12 alert alert-danger form-errors">
                        <ul>
                            @foreach($_error['item'] as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input name="item" value="{{$data->item}}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>   
            <div class="form-group col-md-6">
                <label for="account_meail">Points </label>
                @if($_error['points'])
                    <div class="col-md-12 alert alert-danger form-errors">
                        <ul>
                            @foreach($_error['points'] as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input name="points" value="{{$data->points}}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
        </form>
    </div>
@endsection