@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Rank / Modify Rank Promotion</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/rank'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" id="getmembership" list="{{$member}}">
        <form id="country-add-form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="form-group col-md-12">
                <label for="unilevel">Different Unilevel Leg Count</label>
                <input type="checkbox" name="unilevel" id="unilevel" value="1" {{$data->membership_required_unilevel_leg == 1 ? "checked" : ""}}>
            </div> 
            <div class="form-group col-md-12">
                <label id="changename" for="direct">Direct Counts</label>
                <input name="membership_required_direct" value="{{ $data->membership_required_direct }}" required="required" class="form-control" id="direct" placeholder="" type="text">
            </div>  
            <div class="containerer"></div>
            <div class="form-group col-md-12">
                <label for="pv">Required Group PV Sales</label>
                <input name="membership_required_pv_sales" value="{{ $data->membership_required_pv_sales }}" required="required" class="form-control" id="pv" placeholder="" type="text">
            </div> 
            <div class="form-group col-md-12">
                <label for="month">Months Maintained in Unilevel</label>
                <input name="membership_required_month_count" value="{{ $data->membership_required_month_count }}" required="required" class="form-control" id="month" placeholder="" type="text">
            </div> 
            <div class="form-group col-md-12">
                <label for="account_meail">Allow Promotion</label>
                <select name="upgrade_via_points" class="form-control">
                	<option {{ $data->upgrade_via_points == 1 ? 'selected' : '' }} value="1">Enabled</option>
                	<option {{ $data->upgrade_via_points == 0 ? 'selected' : '' }} value="0">Disabled</option> 
                </select>
            </div>  
        </form>
    </div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){

        $x = jQuery.parseJSON($("#getmembership").attr("list"));

        if({{$data->membership_required_unilevel_leg}} != 0)
        {
           $memid = "{{$data->membership_unilevel_leg_id}}"; 
        }
        else
        {

        }


        if ( $('input[id="unilevel"]').is(':checked') ) 
        {      
            if({{$data->membership_required_unilevel_leg}} == 1)  
            {
               var str = '<div class="form-group col-md-12"><label for="member"> Required Membership in Unilevel Legs</label> <select class="form-control" name="member" id="member">';

                $.each($x, function( key, value ) 
                {
                    if({{$data->membership_required_unilevel_leg}} != 0)
                    {
                            if(value.membership_id == $memid)
                            {
                                str = str + '<option value="'+value.membership_id+'" selected>'+value.membership_name+'</option>';    
                            }
                            else
                            {
                                str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                            }
                    }
                    else
                    {
                             str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                    }


                });  

                str = str + '</select></div>';             
            }     
            else
            {
               var str =    '<div class="form-group col-md-12"><label for="member"> Required Membership in Unilevel Legs</label> <select class="form-control" name="member" id="member">';

                $.each($x, function( key, value ) 
                {
                   str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                });  

                str = str + '</select></div>';                 
            }   


            $(".containerer").append(str);
            $("#changename").text("Direct/Indirect in a Different Unilevel Leg Counts");
        } 
        else
        {
            $(".containerer").empty();
            $("#changename").text("Direct Counts");
        }

        $("#unilevel").click(function()
        {
                if ( $('input[id="unilevel"]').is(':checked') ) 
                {      
                    if({{$data->membership_required_unilevel_leg}} == 1)  
                    {
                       var str = '<div class="form-group col-md-12"><label for="member"> Required Membership in Unilevel Legs</label> <select class="form-control" name="member" id="member">';

                        $.each($x, function( key, value ) 
                        {
                                if({{$data->membership_required_unilevel_leg}} != 0)
                                {
                                        if(value.membership_id == $memid)
                                        {
                                            str = str + '<option value="'+value.membership_id+'" selected>'+value.membership_name+'</option>';    
                                        }
                                        else
                                        {
                                            str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                                        }
                                }
                                else
                                {
                                         str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                                }
                        });  

                        str = str + '</select></div>';             
                    }     
                    else
                    {
                       var str =    '<div class="form-group col-md-12"><label for="member"> Required Membership in Unilevel Legs</label> <select class="form-control" name="member" id="member">';

                        $.each($x, function( key, value ) 
                        {
                           str = str + '<option value="'+value.membership_id+'">'+value.membership_name+'</option>';
                        });  

                        str = str + '</select></div>';                 
                    }   


                    $(".containerer").append(str);
                    $("#changename").text("Direct/Indirect in a Different Unilevel Leg Counts");
                } 
                else
                {
                    $(".containerer").empty();
                    $("#changename").text("Direct Counts");
                }
        });

}); 
</script>
@endsection