@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Indirect Level Bonus / Update</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/indirect'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
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
                <label for="account_contact">Number of Levels</label>
                <input name="membership_indirect_level" value="{{ $data->membership_indirect_level }}" required="required" class="form-control level-input" id="" placeholder="" type="text">
            </div>

            <div class="level-container">
                @foreach($_level as $key => $level)
                <div class="form-group col-md-12">
                    <label for="account_contact">Level {{ $level->level }}</label>
                    <input name="level[{{ $level->level }}]" value="{{ $level->value}}" required="required" class="form-control" id="" placeholder="" type="text">
                </div>
                @endforeach
            </div>
        </form>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function()
    {

        $(".level-input").keyup(function(e)
        {
            $val = $(e.currentTarget).val();
            $(".level-container").html('');
            for($ctr = 0; $ctr < $val; $ctr++)
            {
                $level = $ctr + 1;
                $(".level-container").append(   '<div class="form-group col-md-12">' +
                                                    '<label for="account_contact">Level ' + $level + '</label>' +
                                                    '<input name="level[' + $level + ']" value="0" required="required" class="form-control" id="" placeholder="" type="text">' +
                                                '</div>');
            }
        });
    });
</script>
@endsection