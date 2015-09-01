@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-star-half-o"></i>  Direct Sponsorship Bonus / Update</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/direct'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-12">
                <label for="account_name">Membership Name</label>
                <input disabled="disabled" value="{{ $data->membership_name }}" class="form-control" id="" placeholder="" type="text">
            </div>  
            <div class="form-group col-md-12">
                <label for="account_contact">Direct Sponsorship Bonus (Add % sign if percent of membership price / Fixed value)</label>
                <input name="membership_direct_sponsorship_bonus" value="{{ $data->membership_direct_sponsorship_bonus }}{{$data->if_matching_percentage == 1 ? "%" : ""}}" required="required" class="form-control" id="" placeholder="" type="text">
            </div>
        </form>
    </div>
@endsection