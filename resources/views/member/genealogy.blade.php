@extends('member.layout')
@section('content')
<div class="encashment genealogy" style="margin-top: -20px;">
	 <h3>{{ strtoupper(Request::input("mode")) }} GENEALOGY</h3>
	<div class="body para">
		 <iframe src="/member/genealogy/tree?mode={{ Request::input("mode") }}" style="width: 100%; height: 510px; border: 0;"></iframe> 
	</div>
</div>

@if($code)
<!-- NEW SLOT -->
<div class="remodal create-slot" data-remodal-id="newslot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
    <span class="removeifempty"><img src="/resources/assets/frontend/img/icon-plis.png"></span>
    <span class="changeifempty">    Create New Slot</span>
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="removeifempty col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" id="slotnew">
            <div class="form-group para">
                <label for="latest" class="col-sm-3 control-label">Slot #</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control position" id="latest" disabled>
                </div>
            </div>
            <div class="form-group para">
                <label for="111" class="col-sm-3 control-label">Membership Codes</label>
                <input name="product_pin" class="product-code-id-reference" type="hidden" id="product_code_id" value="">
                <div class="col-sm-9">
                    <select class="form-control" id="111" name="code">
                        @if($code)
                            @foreach($code as $get)
                                <option value="{{$get->code_pin}}">{{$get->code_pin}} @ {{$get->code_activation}}</option> 
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="position" class="col-sm-3 control-label">Position</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control position" id="position" readonly name="position">
                </div>
            </div>
            <div class="form-group para">
                <label for="sponsor" class="col-sm-3 control-label">Sponsor</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control position" id="sponsor" name="sponsor" placeholder="Put an existing slot">
                </div>
            </div>
            <div class="form-group para">
                <label for="placement" class="col-sm-3 control-label">Placement</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control type" id="placement" disabled>
                    <input type="hidden" class="form-control type" id="placement2" name="placement">
                </div>
            </div>
            <div class="form-group para">
                <label for="type" class="col-sm-3 control-label">Slot Type</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control type" id="type" readonly name="type">
                </div>
            </div>
            <div class="form-group para">
                <label for="membership_name" class="col-sm-3 control-label">Membership</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control membership" id="membership" disabled>
                </div>
            </div>
        </div>
        <br>
        <span class="removeifempty"><button class="button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="button" type="button" name="usingcode" id="use">Use Code</button></span>
    </form>
    </div>
</div>
@else
<!-- NEW SLOT -->
<div class="remodal create-slot" data-remodal-id="newslot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        You have no available codes
    </div>
</div>
@endif
<!-- SUCCESS SLOT -->
<div class="remodal create-slot" data-remodal-id="slotcreated" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
    <img src="/resources/assets/frontend/img/icon-claim.png">
        Successfully Added
    </div>

</div>
@endsection

@section('script')
<script type="text/javascript">
var container = null;
var forthis = null


$('iframe').load(function()
{ 
    $(this).contents().find("body").on('click','.positioning', function(event)
    { 
               forthis = $(this).closest('.downline-container').parent().children('span:first');
               container = $(this).closest('.downline-container').find("ul");
               var position = $(this).attr('position');
               var placement = $(this).attr('placement'); 
               $('#placement').val('Slot #'+placement);
               $('#placement2').val(placement);
               $('#position').val(position);
               $('#sponsor').val(placement);
               var inst = $('[data-remodal-id=newslot]').remodal();
               inst.open(); 
                        $("#membership").val('Loading...');
                        $("#type").val('Loading...');     
                        $.ajax(
                        {
                            url:"member/genealogy/get",
                            dataType:"json",
                            data: {'code':$("#111").val()},
                            type:"post",
                            success: function(data)
                            {
                                if(data['code'] != "x")
                                { 
                                    $x = jQuery.parseJSON(data['code']);

                                    $("#latest").val(data['latest']);
                                    $("#membership").val($x.membership_name);
                                    $("#type").val($x.code_type_name);     
                                    $("#newslot").val(data['latest']); 


                                }
                            }
                });      
    });

        $("#111").bind('change',function()
        {
                        $("#membership").val('Loading...');
                        $("#type").val('Loading...');     
                        $.ajax(
                        {
                            url:"member/genealogy/get",
                            dataType:"json",
                            data: {'code':$("#111").val()},
                            type:"post",
                            success: function(data)
                            {
                                if(data['code'] != "x")
                                { 
                                    $x = jQuery.parseJSON(data['code']);
                                    $("#latest").val(data['latest']);
                                    $("#membership").val($x.membership_name);
                                    $("#type").val($x.code_type_name); 
                                }
                                else
                                {
                                    // if($('.sponse').val() == "")
                                    // {
                                    //     $('.c_slot').prop("disabled", true);
                                    //     $(".tree").empty();
                                    //     $(".tree").append('<option value="">Input a slot sponsor</option>');
                                    // } 
                                    // else
                                    // {
                                    //     $('.c_slot').prop("disabled", true);
                                    //     $(".tree").empty();
                                    //     $(".tree").append('<option value="">Sponsor slot number does not exist.</option>');
                                    // }
     
                                }
                            }
                        }); 
        });

        $("#use").unbind("click");
        $("#use").bind("click", function(e)
        {
            $('#use').prop("disabled", true);
            $.ajax(
            {
                url:"member/genealogy/add_form",
                dataType:"json",
                data: $("#slotnew").serialize(),
                type:"post",
                success: function(data)
                {
                    $('#use').prop("disabled", false);
                    if(data.message == "")
                    {
                                        container.remove();
                                        $("#111").find('option:selected').remove();;
                                        var inst = $('[data-remodal-id=newslot]').remodal();
                                        inst.close();                                      
                                        var inst = $('[data-remodal-id=slotcreated]').remodal();
                                        inst.open();  
                                        $(forthis).trigger('click');  
                                        $(forthis).trigger('click'); 
                                        if($('#111 option').length <= 0)
                                        {
                                            $(".removeifempty").remove();
                                            $('.changeifempty').text('You have no available codes');
                                        } 
                    }
                    else
                    {
                        alert(data.message);
                    }
                }
            });
        });
});

</script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/genealogy.css">
@endsection