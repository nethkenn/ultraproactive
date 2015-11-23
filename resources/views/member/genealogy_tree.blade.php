<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
@if($slot_tree)
<html>
    <head>
        <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] ?>">
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/resources/assets/members/css/member.css">
        <script type="text/javascript" src="resources/assets/genealogy/drag.js"></script>
        <link rel="stylesheet" type="text/css" href="/resources/assets/genealogy_tree/bootstrap/css/bootstrap.css">
        <script type="text/javascript" src="/resources/assets/genealogy_tree/bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/jquery.remodal.css">
        <link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/remodal-default-theme.css">
        <link rel="stylesheet" type="text/css" href="resources/assets/member/css/genealogy.css?version=2" />
        <title>Genealogy</title>
        <link rel="stylesheet" type="text/css" href="/resources/assets/members/css/member.css">
    </head>
    <body id="body" class="body" style="height: 100%">
            <nav class="navbar navbar-default">
              <div>
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>

                <!-- NAVIGATION -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="overflow: hidden;">
                  <ul class="nav navbar-nav">
                    <li class="{{ Request::segment(2) == '' ? 'active' : '' }}"><a href="/member">Dashboard</a></li>
                    <li class="{{ Request::segment(2) == 'slot' ? 'active' : '' }}"><a href="/member/slot">My Slots</a></li>
                    <li class="{{ Request::segment(2) == 'code_vault' ? 'active' : '' }}"><a href="/member/code_vault">Code Vault</a></li>
                    <li class="{{ Request::segment(2) == 'genealogy' ? 'active' : '' }} dropdown">
                        <a href="javascript:">Genealogy</a>
                        <ul class="dropdown-menu">
                            <li><a href="/member/genealogy/tree?mode=binary">Binary Genealogy</a></li>
                            <li><a href="/member/genealogy/tree?mode=sponsor">Sponsor Genealogy</a></li>
                        </ul>
                    </li>
                    <li class="{{ Request::segment(2) == 'encashment' ? 'active' : '' }} {{ Request::segment(2) == 'transfer_wallet' ? 'active' : '' }} dropdown">
                        <a href="javascript:">Wallet</a>
                        <ul class="dropdown-menu">
                            <li><a href="/member/encashment">Encashment</a></li>
                            <!-- <li><a href="/member/transfer_wallet">Transfer Wallet</a></li> -->
                        </ul>
                    </li>
                    <li class="{{ Request::segment(2) == 'product' ? 'active' : '' }}"><a href="/member/product">Product</a></li>
                    <li class="{{ Request::segment(2) == 'voucher' ? 'active' : '' }}"><a href="/member/voucher">Voucher</a></li>
                    <li class="{{ Request::segment(2) == 'leads' ? 'active' : '' }}"><a href="/member/leads">Leads</a></li>
                    <li class="{{ Request::segment(2) == 'reports' ? 'active' : '' }} dropdown">
                        <a href="javascript:">Reports</a>
                        <ul class="dropdown-menu">
                            <li><a href="/member/reports/income_summary">Income Summary</a></li>
                        </ul>
                    </li>
                   <li class="{{ Request::segment(2) == 'genealogy' ? 'active' : '' }} dropdown hide">
                        <!--<a href="/member/genealogy?mode=binary">E-payment</a>-->
                        <a href="member/e-payment/">E-payment</a>
                        <ul class="dropdown-menu">
                            <li><a href="member/e-payment/recipient">E-payment Recipient</a></li>
                            <li><a href="member/e-payment/transaction-log">E-payment Transaction</a></li>

                        </ul>
                    </li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right" style="margin-right: 0;">
                     <li>
                        @if($slotnow)
                        <a href="javascript:" class="dropdown-toggle hidden-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SLOT #{{$slotnow->slot_id}} <span>{{ number_format($current_wallet, 2)}}</span> | GC <span>{{ number_format($current_gc, 2)}}</span>  <b class="caret"></b></a>
                        @else
                        <a href="javascript:" class="dropdown-toggle hidden-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NO SLOTS<b class="caret"></b></a>
                        @endif
                        <ul class="dropdown-menu scrollable-menu hidden-sm" style="text-transform: normal">
                            @if($slot)                                                    
                                @foreach($slot as $slots)
                                       <li><a class="forslotchanging" slotid='{{$slots->slot_id}}' href="javascript:">SLOT #{{$slots->slot_id}} <span>{{ number_format($slots->total_wallet, 2)}}</span> |  GC <span>{{ number_format($slots->total_gc, 2)}}</span></a></li> 
                                @endforeach
                            @endif      
                            <li><a href="/member/settings">Account Settings</a></li>
                            <li><a href="/member/settings#cpass">Change Password</a></li>
                            <li><a href="/member/logout">Sign out</a></li>
                        </ul>
                     </li>
                  </ul>
                </div>
              </div><!-- /.container-fluid -->
            </nav>
        <div class="overscroll" style="width: 100%; height: inherit; overflow: auto;">
            <div class="tree-container" style="width: 5000%; padding: 20px; height: 5000%;">
                <div class="tree">
                    <ul>
                        <li class="width-reference">
                            <span class="downline parent parent-reference PS" x="{{ $slot_tree->slot_id }}">   
                                <div id="info">
                                    <div id="photo">
                                        @if($member->image != "")
                                        <img src="{{$slot_tree->image}}">
                                        @else
                                        <img src="/resources/assets/img/default-image.jpg">
                                        @endif
                                    </div>
                                    <div id="cont">
                                        <div style="font-weight: 700;">{{ strtoupper($slot_tree->account_username) }}</div>
                                        <div>{{ strtoupper($slot_tree->account_name) }}</div>
                                        <b>{{ $slot_tree->membership_name }}</b>
                                    </div>
                                    <div>{{ $slot_tree->slot_type }}</div>
                                    <div>L:{{$l}} / R:{{$r}}</div>
                                    <div>Left Points:{{$slot_tree->slot_binary_left}} / Right Points:{{$slot_tree->slot_binary_right}}</div>
                                </div>
                                <div class="id">{{ $slot_tree->slot_id }}</div>
                            </span> 
                            <i class="downline-container">
                                {!! $downline !!}
                            </i>                  
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
                url:"member/genealogy/add_form_message",
                dataType:"json",
                data: $("#slotnew").serialize(),
                type:"post",
                success: function(data)
                {
                    $('#use').prop("disabled", false);
                    if(data.message == "")
                    {
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

                    }
                    else
                    {
                        alert(data.message);
                        $(".usingcode").show();  
                        $(".loadingusecode").hide();
                    }
                }
            });

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

        }); 

       $('.forslotchanging').click(function()
       {
                $.ajax(
                {
                            url:"member/slot/changeslot",
                            dataType:"json",
                            data: {'changeslot':$(this).attr('slotid'),'_token':$("#token").val()},
                            type:"post",
                            success: function(data)
                            {
                                if(mode != null)
                                {
                                    window.location.href = window.location.pathname+"?mode="+mode;
                                }
                                else
                                {
                                    window.location.href = window.location.pathname;    
                                }   
                            }
                });      
       });


</script>
