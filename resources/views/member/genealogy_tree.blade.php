<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
@if($slot)
<html>
    <head>
        <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] ?>">
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/resources/assets/members/css/member.css">
        <script type="text/javascript" src="resources/assets/genealogy/drag.js"></script>
        <link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/jquery.remodal.css">
        <link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/remodal-default-theme.css">
        <link rel="stylesheet" type="text/css" href="resources/assets/member/css/genealogy.css" />
        <title>Genealogy</title>
    </head>
    <body id="body" class="body" style="height: 100%">
        <div class="overscroll" style="width: 100%; height: inherit; overflow: auto;">
            <div class="tree-container" style="width: 5000%; padding: 20px; height: 5000%;">
                <div class="tree">
                    <ul>
                        <li class="width-reference">
                            <span class="downline parent parent-reference PS" x="{{ $slot->slot_id }}">   
                                <div id="info">
                                    <div id="photo">
                                        @if($member->image != "")
                                        <img src="{{$slot->image}}">
                                        @else
                                        <img src="/resources/assets/img/default-image.jpg">
                                        @endif
                                    </div>
                                    <div id="cont">
                                        <div>{{ strtoupper($slot->account_name) }} ({{$slot->account_username}})</div>
                                        <b>{{ $slot->membership_name }}</b>
                                    </div>
                                    <div>{{ $slot->slot_type }}</div>
                                    <div>L:{{$l}} R:{{$r}}</div>
                                </div>
                                <div class="id">{{ $slot->slot_id }}</div>
                            </span> 
                            <i class="downline-container">
                                {!! $downline !!}
                            </i>                  
                            <!--
                            <ul>
                                
                                <li class="width-reference">
                                    <span class="downline parent parent-reference  PS SILVER" x="2">
                                        <div id="info">
                                            <div id="cont">
                                                <div>{{ $slot->membership_type }} </div>
                                                <b>{{ $slot->membership_name }} </b>
                                            </div>
                                            <div>{{ $slot->account_name }} </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="id">2</div>
                                    </span>
                                    <i class="downline-container"></i>
                                </li>
                                <li class="width-reference">
                                    <span class="downline parent parent-reference  PS SILVER" x="3">
                                        <div id="info">
                                            <div id="cont">
                                                <div>PS</div>
                                                <b>SILVER</b>
                                            </div>
                                            <div>P5</div>
                                            <div>July 06, 2015 - 01:31 AM</div>
                                        </div>
                                        <div class="id">3</div>
                                    </span>
                                    <i class="downline-container"></i>
                                </li>
                            </ul>
                            -->
                        </li>
                    </ul>       
                </div>
            </div>
        </div>   
    </body>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

@if($code)
<!-- NEW SLOT -->
<div class="remodal create-slot" data-remodal-id="newslot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
    <span class="removeifempty"><img src="/resources/assets/frontend/img/icon-plis.png"></span>
    <span class="changeifempty">    Create New Slot</span>
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="removeifempty col-md-10 col-md-offset-1 ">
        <form class="form-horizontal" id="slotnew">

            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokens">
            <div class="field ">

                <label for="latest" class="col-sm-3 control-label">Slot #</label>
                <div  >
                    <input type="text" class="form-control position" id="latest" disabled>
                </div>
            </div>
            <div class="field ">
                <label for="111" class="col-sm-3 control-label">Membership Codes</label>
                <input name="product_pin" class="product-code-id-reference" type="hidden" id="product_code_id" value="">
                <div  >
                    <select class="form-control" id="111" name="code">
                        @if($code)
                            @foreach($code as $get)
                                <option value="{{$get->code_pin}}">{{$get->code_pin}} @ {{$get->code_activation}}</option> 
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="field ">
                <label for="acc" class="col-sm-3 control-label">Give slot to</label>
                <input name="product_pin" class="product-code-id-reference" type="hidden" id="product_code_id" value="">
                <div  >
                    <select class="form-control" id="acc" name="acc">
                            <option value="{{$id}}">Your account</option> 
                        @if($getlead)
                            @foreach($getlead as $get)
                                <option value="{{$get->account_id}}">{{$get->account_name}}</option> 
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="field ">
                <label for="position" class="col-sm-3 control-label">Position</label>
                <div  >
                    <input type="text" class="form-control position" id="position" readonly name="position">
                </div>
            </div>
            <div class="field ">
                <label for="sponsor" class="col-sm-3 control-label">Sponsor</label>
                <div  >
                    <input type="text" class="form-control position" id="sponsor" name="sponsor" placeholder="Put an existing slot">
                </div>
            </div>
            <div class="field ">
                <label for="sponsor" class="col-sm-3 control-label">Sponsor Name</label>
                <div  >
                    <input type="text" for="sponsor" class="sponsorname form-control" disabled ></input>
                </div>
            </div>
            <div class="field ">
                <label for="placement" class="col-sm-3 control-label">Placement</label>
                <div  >
                    <input type="text" class="form-control type" id="placement" disabled>
                    <input type="hidden" class="form-control type" id="placement2" name="placement">
                </div>
            </div>
            <div class="field ">
                <label for="type" class="col-sm-3 control-label">Slot Type</label>
                <div  >
                    <input type="text" class="form-control type" id="type" readonly name="type">
                </div>
            </div>
            <div class="field ">
                <label for="membership_name" class="col-sm-3 control-label">Membership</label>
                <div  >
                    <input type="text" class="form-control membership" id="membership" disabled>
                </div>
            </div>
        </div>
        <br>
        <span class="removeifempty"><button class="button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="usingcode button" type="button" name="usingcode" id="use">Use Code</button></span>
        <span class='loadingusecode' style="margin-left: 50px;"><img class='loadingusecode' src='/resources/assets/img/small-loading.GIF'></span>
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

@if($code)
<!-- NEW SLOT -->
<div class="remodal create-slot" data-remodal-id="newslot" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
    <span class="removeifempty"><img src="/resources/assets/frontend/img/icon-plis.png"></span>
    <span class="changeifempty">    Create New Slot</span>
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="removeifempty col-md-10 col-md-offset-1 ">
        <form class="form-horizontal" id="slotnew">
            <div class="field ">
                <label for="latest" class="col-sm-3 control-label">Slot #</label>
                <div  >
                    <input type="text" class="form-control position" id="latest" disabled>
                </div>
            </div>
            <div class="field ">
                <label for="111" class="col-sm-3 control-label">Membership Codes</label>
                <input name="product_pin" class="product-code-id-reference" type="hidden" id="product_code_id" value="">
                <div  >
                    <select class="form-control" id="111" name="code">
                        @if($code)
                            @foreach($code as $get)
                                <option value="{{$get->code_pin}}">{{$get->code_pin}} @ {{$get->code_activation}}</option> 
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="field ">
                <label for="acc" class="col-sm-3 control-label">Give slot to</label>
                <input name="product_pin" class="product-code-id-reference" type="hidden" id="product_code_id" value="">
                <div  >
                    <select class="form-control" id="acc" name="acc">
                            <option value="{{$id}}">Your account</option> 
                        @if($getlead)
                            @foreach($getlead as $get)
                                <option value="{{$get->account_id}}">{{$get->account_name}}</option> 
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="field ">
                <label for="position" class="col-sm-3 control-label">Position</label>
                <div  >
                    <input type="text" class="form-control position" id="position" readonly name="position">
                </div>
            </div>
            <div class="field ">
                <label for="sponsor" class="col-sm-3 control-label">Sponsor</label>
                <div  >
                    <input type="text" class="form-control position" id="sponsor" name="sponsor" placeholder="Put an existing slot">
                </div>
            </div>
            <div class="field ">
                <label for="sponsor" class="col-sm-3 control-label">Sponsor Name</label>
                <div  >
                    <input type="text" for="sponsor" class="sponsorname form-control" disabled ></input>
                </div>
            </div>
            <div class="field ">
                <label for="placement" class="col-sm-3 control-label">Placement</label>
                <div  >
                    <input type="text" class="form-control type" id="placement" disabled>
                    <input type="hidden" class="form-control type" id="placement2" name="placement">
                </div>
            </div>
            <div class="field ">
                <label for="type" class="col-sm-3 control-label">Slot Type</label>
                <div  >
                    <input type="text" class="form-control type" id="type" readonly name="type">
                </div>
            </div>
            <div class="field ">
                <label for="membership_name" class="col-sm-3 control-label">Membership</label>
                <div  >
                    <input type="text" class="form-control membership" id="membership" disabled>
                </div>
            </div>
        </div>
        <br>
        <span class="removeifempty"><button class="button" type="button" data-remodal-action="cancel">Cancel</button>
        <button class="usingcode button" type="button" name="usingcode" id="use">Use Code</button></span>
        <span class='loadingusecode' style="margin-left: 50px;"><img class='loadingusecode' src='/resources/assets/img/small-loading.GIF'></span>
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
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript">
    var mode = "{{ Request::input('mode') }}";
    var g_width = 0;
    var half;
    
    $(document).ready(function()
    {  

        $("li").show();   
        half = $(window).width() * 2500;
        g_width = $(".width-reference").width();
        $margin_left = ($(window).width() - $(".width-reference").width()) / 2;
        $(".tree-container").css("padding-left",half  + $margin_left);
        $(".overscroll").height($(document).height());
        
        
        $parent_position = $(".parent").position();
        $window_size = $(window).width();
        
        $(function(o){
            o = $(".overscroll").overscroll(
            {
                cancelOn: '.no-drag',
                scrollLeft: half,
                scrollTop: 0
            });
            $("#link").click(function()
            {
                if(!o.data("dragging"))
                {
                    console.log("clicked!");
                }
                else
                {
                    return false;
                }
            });
        }); 
        
        
    })
    
    var genealogy_loader = new genealogy_loader();
    function genealogy_loader()
    {
        init();
        function init()
        {
            $(document).ready(function()
            { 
                document_ready();
            });
        }
        function document_ready()
        {
            add_click_event_to_downlines();
        }
        function add_click_event_to_downlines()
        {      
            $(".downline").unbind("click");
            $(".downline").bind("click", function(e)
            {
                $currentScroll = $(".overscroll").scrollLeft();
                
                if($(e.currentTarget).siblings(".downline-container").find("ul").length == 0)
                {
                    $(e.currentTarget).append("<div class='loading'><img src='/resources/assets/img/485.gif'></div>");
                    $(".downline").unbind("click");
                    
                    $genealogy = $(e.currentTarget).attr("genealogy_function");
                    $networker_account_id = $(e.currentTarget).attr("x");
                    
                    $.ajax(
                    {
                        url:"/member/genealogy/downline",
                        dataType:"json",
                        data:{x:$networker_account_id,complan_library:$genealogy,mode:mode},
                        type:"get",
                        success: function(data)
                        {    
                            $(".loading").remove();
                            $(e.currentTarget).siblings(".downline-container").append(data);
                            $(e.currentTarget).siblings(".downline-container").find("li").fadeIn();
                            adjust_tree();
                            add_click_event_to_downlines();
                            adjust_tree();
                            //$(e.currentTarget).parent("li").siblings("li").find("ul").remove();
                        }
                    });    
                }
                else
                {
                    $(e.currentTarget).siblings(".downline-container").find("ul").fadeOut(function()
                    {
                        this.remove();
                        adjust_tree();    
                    });
                    
                }
            });    
        }     
        function adjust_tree()
        {
                $curr_margin_left = parseFloat($(".tree-container").css("padding-left"));   
                $deduction = parseFloat(($(".width-reference").width() - g_width) / 2);
                g_width = $(".width-reference").width();
                $(".tree-container").css("padding-left", parseFloat($curr_margin_left  - $deduction));
        }
    }
</script>
</html>
@else
You have no slots available.
@endif





<script type="text/javascript">
var container = null;
var forthis = null

       $('#body').on('click', '.positioning', function()
       {
               forthis = $(this).closest('.downline-container').parent().children('span:first');
               console.log(forthis);
               container = $(this).closest('.downline-container').find("ul");
               var position = $(this).attr('position');
               var placement = $(this).attr('placement');
               var name = $(this).attr('y'); 
               $('#placement').val('Slot #'+placement +' ('+name+')');
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
                            data: {'code':$("#111").val(),'_token':$("#token").val()},
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
                                else
                                {

                                }
                            }
                }); 

                $(".sponsorname").val("Loading...");  
                $.ajax(
                {
                    url:"member/code_vault/get",
                    dataType:"json",
                    data: {'slot':$("#sponsor").val(),'_token':$("#token").val()},
                    type:"post",
                    success: function(data)
                    {
                        if(data != "x")
                        { 
                          $x = jQuery.parseJSON(data);
                          $(".sponsorname").val($x[1]);                            
                        }
                        else
                        {
                           $(".sponsorname").val("Sponsor's ID is not existing");  
                        }
                    } 
                });     
       })




        $("#111").bind('change',function()
        {
                        $("#membership").val('Loading...');
                        $("#type").val('Loading...');     
                        $.ajax(
                        {
                            url:"member/genealogy/get",
                            dataType:"json",
                            data: {'code':$("#111").val(),'_token':$("#token").val()},
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
<<<<<<< HEAD
                url:"member/genealogy/add_form_message",
=======
                url:"member/genealogy/add_form",
>>>>>>> 40cef46f276c7395d79c5e901953c7e3d8192143
                dataType:"json",
                data: $("#slotnew").serialize(),
                type:"post",
                success: function(data)
                {
                    $('#use').prop("disabled", false);
                    if(data.message == "")
                    {
<<<<<<< HEAD
                                        $.ajax(
                                        {
                                            url:"member/genealogy/add_form",
                                            dataType:"json",
                                            data: $("#slotnew").serialize(),
                                            type:"post",
                                            complete: function (asd) 
                                            {
                                                container.remove();
                                                $("#111").find('option:selected').remove();;
                                                var inst = $('[data-remodal-id=newslot]').remodal();
                                                inst.close();                                      
                                                var inst = $('[data-remodal-id=slotcreated]').remodal();
                                                inst.open();   
                                                if($('#111 option').length <= 0)
                                                {
                                                    $(".removeifempty").remove();
                                                    $('.changeifempty').text('You have no available codes');
                                                    $(".loadingusecode").hide();
                                                } 
                                                else
                                                {
                                                     $(".usingcode").show();  
                                                     $(".loadingusecode").hide();
                                                }   
                                            }
                                        });
=======
                                        container.remove();
                                        $("#111").find('option:selected').remove();;
                                        var inst = $('[data-remodal-id=newslot]').remodal();
                                        inst.close();                                      
                                        var inst = $('[data-remodal-id=slotcreated]').remodal();
                                        inst.open();  

                                        if($('#111 option').length <= 0)
                                        {
                                            $(".removeifempty").remove();
                                            $('.changeifempty').text('You have no available codes');
                                            $(".loadingusecode").hide();
                                        } 
                                        else
                                        {
                                             $(".usingcode").show();  
                                             $(".loadingusecode").hide();
                                        } 
>>>>>>> 40cef46f276c7395d79c5e901953c7e3d8192143

                    }
                    else
                    {
                        alert(data.message);
                        $(".usingcode").show();  
                        $(".loadingusecode").hide();
                    }
                }
            });
<<<<<<< HEAD

=======
>>>>>>> 40cef46f276c7395d79c5e901953c7e3d8192143
        });
        $(".loadingusecode").hide();
        $(".usingcode").click(function(e)
        {
                 $(".usingcode").hide();  
                 $(".loadingusecode").show();
        });



        $("#sponsor").keyup(function()
        {           
                    $(".sponsorname").val("Loading...");  
                    $.ajax(
                    {
                        url:"member/code_vault/get",
                        dataType:"json",
<<<<<<< HEAD
                        data: {'slot':$("#sponsor").val(),'_token':$("#token").val()},
=======
                        data: {'slot':$("#sponsor").val()},
>>>>>>> 40cef46f276c7395d79c5e901953c7e3d8192143
                        type:"post",
                        success: function(data)
                        {
                            if(data != "x")
                            { 
                              $x = jQuery.parseJSON(data);
                              $(".sponsorname").val($x[1]);                            
                            }
                            else
                            {
                               $(".sponsorname").val("Sponsor's ID is not existing");  
                            }
                        } 
                    });
<<<<<<< HEAD
=======

>>>>>>> 40cef46f276c7395d79c5e901953c7e3d8192143
        }); 


</script>
