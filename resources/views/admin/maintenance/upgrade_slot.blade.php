@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>Upgrade</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/maintenance/slot'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        </div>
    </div>
	@if(isset($message))
		  	@if($message == "Success")
		 		<div class="alert alert-success">
				  	Successfully upgraded.
				</div>
			@else 
				<div class="alert alert-danger">
				  	{{$message}}
				</div>	
			@endif
	@endif
    <div class="col-md-12 form-group-container">
        <form id="country-add-form" method="post" action="admin/maintenance/slots/upgrade_slot/submit">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-6">
                <label for="slot_id">Slot Id</label>
                <select class="form-control slot_id" name="slot_id">
                    @foreach($_slot as $slot)
                        <option value="{{$slot->slot_id}}">{{$slot->slot_id}}</option>
                    @endforeach
                </select>
            </div>       
            
            <div class="form-group col-md-6">
                <label for="account_name membership_id">Membership</label>
                <select class="form-control membership_id" name="membership_id">

                </select>
            </div>  
			<div class="buttons col-md-4">
                    Current Membership: <b><span class="your_membership"></span></b>
			</div> 
			<div class="buttons col-md-6 text-right">

			</div>
			<div class="buttons col-md-2 text-right">
				<button class="btn btn-primary" type="submit" style="width: 100%;">Upgrade</button>
			</div>	
        </form>
    </div>
@endsection

@section('script')
<script type="text/javascript">
change_slot();
get_membership();


function change_slot()
{
    $(".slot_id").change(function()
    {
        get_membership();
    });
}

function get_membership()
{
    $(".membership_id").empty();
    $(".your_membership").empty();
    var slot_id = $(".slot_id").val();
    $.get( "admin/maintenance/slots/upgrade_slot/get_membership/"+slot_id, function( data ) 
    {
        data = jQuery.parseJSON(data);
        if(data.membership != null)
        {
            $(".your_membership").text(data.current_membership.membership_name);
            var str ="";
            
            $.each( data.membership, function( key, value ) 
            {
              str += "<option value="+value.membership_id+">"+value.membership_name+"</option>";
            });
            
            
            $(".membership_id").append(str);
        }
        else
        {
           
        }
    });
}
</script>
@endsection