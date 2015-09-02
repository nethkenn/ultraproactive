@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-star-half-o"></i>  Mentor Bonus/ Update</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/matching'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" id="getmembership" list="{{$member}}">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-12">
                <label for="account_name">Membership Name</label>
                <input disabled="disabled" value="{{ $data->membership_name }}" class="form-control" id="" placeholder="" type="text">
            </div>    

            <div class="form-group col-md-12">
                <label for="account_contact">Number of Levels</label>
                <input name="membership_mentor_level" value="{{ $data->membership_mentor_level }}" required="required" class="form-control level-input" id="" placeholder="" type="text">
            <hr style="width: 100%; color: black; height: 1px; background-color:black;"/>
            </div>
        

            <div class="level-container">
                @if($_level)
                    @foreach($_level as $key => $level)
                    <div class="form-group col-md-12">
                     <label for="account_contact">Level {{ $level->level }} (0-100%)</label>
                     <input name="level[level][{{ $level->level }}]" value="{{$level->matching_percentage}}" required="required" class="form-control" id="" placeholder="" type="text">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="account_contact">How many required member to have bonus?</label>
                        <input name="level[count][{{$level->level}}]" value="{{$level->matching_requirement_count}}" required="required" class="form-control" id="" placeholder="" type="text">
                        <hr style="width: 100%; color: black; height: 1px; background-color:black;"/>
                    </div>
                    @endforeach
                @endif
            </div>
        </form>
    </div>
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
                                                    '<input name="level[level][' + $level + ']" value="0" required="required" class="form-control" id="" placeholder="" type="text">' +
                                                '</div>');

                // var str =    '<div class="form-group col-md-12"><label for="account_contact"> Direct Sponsor Required Membership </label> <select class="form-control" name="level[member]['+$level+']">';



                // $.each($x, function( key, value ) 
                // {
                //    str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                // });  

                // str = str + '</select></div>';

                // $(".level-container").append(str);
                $(".level-container").append('<div class="form-group col-md-12">' +
                                    '<label for="account_contact">How many required member to have bonus?</label>' +
                                    '<input name="level[count][' + $level + ']" value="0" required="required" class="form-control" id="" placeholder="" type="text">' +
                                    '<hr style="width: 100%; color: black; height: 1px; background-color:black;"/></div>');
            }
        });



    });
</script>
@endsection
@endsection
