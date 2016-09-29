@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i> COMPENSATION </h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/rank/compensation/'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    
    @if(isset($_error))
        <div class="col-md-12 alert alert-danger form-errors">
            <ul>
                @foreach($_error as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group col-md-12">
                <label for="compensation_rank_name">Compensation Name</label>
                <input name="compensation_rank_name" value="{{Request::old('compensation_rank_name') ? Request::old('compensation_rank_name') : $rank->compensation_rank_name }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>            
            <div class="form-group col-md-12">
                <label for="required_group_pv">Required Group UPcoins</label>
                <input name="required_group_pv" value="{{Request::old('required_group_pv') ? Request::old('required_group_pv') : $rank->required_group_pv }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>            
            <div class="form-group col-md-12">
                <label for="required_personal_pv">Required Personal UPcoins</label>
                <input name="required_personal_pv" value="{{Request::old('required_personal_pv') ? Request::old('required_personal_pv') : $rank->required_personal_pv }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>              
            <div class="form-group col-md-12">
                <label for="required_personal_pv_maintenance">Required Personal PV Maintenance</label>
                <input name="required_personal_pv_maintenance" value="{{Request::old('required_personal_pv_maintenance') ? Request::old('required_personal_pv_maintenance') : $rank->required_personal_pv_maintenance }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>            
            <div class="form-group col-md-12">
                <label for="rank_max_pairing">Max Pairing</label>
                <input name="rank_max_pairing" value="{{Request::old('rank_max_pairing') ? Request::old('rank_max_pairing') : $rank->rank_max_pairing }}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>  
        </form>
    </div>
@endsection