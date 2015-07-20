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
                <input name="label" required="required" class="form-control" id="lbl" placeholder="" type="text" value="{{$d->deduction_label}}" required>
            </div>  
            <div class="form-group col-md-6">
                <label for="country">Target Country</label>
                <select name="country" class="form-control" id="country">
                    @if($d)
                        <option value="All Country" {{$d->target_country == "All Country" ? "checked" : ""}}> All Country </option>
                        @if($country)
                            @foreach($country as $c2)
                                <option value="{{$c2->country_id}}" {{$d->target_country == $c2->country_id ? "selected" : ""}}>{{$c2->country_name}}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div> 
            <div class="form-group col-md-6">
                <label for="amt">Deduction Amount (eg. 1500 or 50%)</label>
                <input name="amt" value="{{$d->percent == 1 ? $d->deduction_amount.'%' : $d->deduction_amount }}" required="required" class="form-control" id="amt" placeholder="" type="text" required>
            </div>  
        </form>
    </div>
@endsection