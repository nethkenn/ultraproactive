@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-star-half-o"></i> LEADERSHIP BONUS PERCENTAGE / Update</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/leadership_bonus'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
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
                <label for="account_name">Leadership Bonus</label>
                <input name="leadership_bonus" value="{{ $data->leadership_bonus }}" class="form-control" id="" placeholder="" type="number">
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
                                                    '<label for="account_contact">Level ' + $level + ' (0-100%)</label>' +
                                                    '<input name="level[' + $level + ']" value="0" required="required" class="form-control" id="" placeholder="" type="text">' +
                                                '</div>');
            }
        });
    });
</script>
@endsection