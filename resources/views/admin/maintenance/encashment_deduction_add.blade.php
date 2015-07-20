@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Deduction / Add New</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/maintenance/deduction'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-6">
                <label for="lbl">Deduction Label</label>
                <input name="label" value="" required="required" class="form-control" id="lbl" placeholder="" type="text" required>
            </div>  
            <div class="form-group col-md-6">
                <label for="target">Target Country</label>
                <select name="country" class="form-control" id="target">
                    @if($country)
                        <option value="All Country"> All Country </option>
                        @foreach($country as $c)
                        <option value="{{$c->country_id}}">{{$c->country_name}}</option>
                        @endforeach
                    @endif
                </select>
            </div> 
            <div class="form-group col-md-6">
                <label for="amt">Deduction Amount (eg. 1500 or 50%)</label>
                <input name="amt" value="" required="required" class="form-control" id="amt" placeholder="" type="text" required>
            </div>  
        </form>
    </div>
@endsection