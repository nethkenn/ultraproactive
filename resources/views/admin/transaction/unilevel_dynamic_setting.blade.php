@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-star-half-o"></i> SPONSOR LEVELS / Update</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/transaction/unilevel/dynamic'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group col-md-12">
                <label for="account_contact">Number of Levels</label>
                <input name="membership_repurchase_level" value="{{$countall}}" required="required" class="form-control level-input" id="" placeholder="" type="text">
            </div>

            <div class="level-container">
                @foreach($data as $key => $level)
                <div class="form-group col-md-12">
                    <label for="account_contact">Level {{ $level->count_level }} (0-100%)</label>
                    <input name="level[{{ $level->count_level }}]" value="{{ $level->percentage}}" required="required" class="form-control" id="" placeholder="" type="text">
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
                                                    '<label for="account_contact">Level ' + $level + ' (0-100%)</label>' +
                                                    '<input name="level[' + $level + ']" value="0" required="required" class="form-control" id="" placeholder="" type="text">' +
                                                '</div>');
            }
        });
    });
</script>
@endsection