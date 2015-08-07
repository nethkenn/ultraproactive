<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
@if($slot)
<html>
    <head>
        <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] ?>">
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
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
                                        <img src="/resources/assets/img/default-image.jpg" alt="" />
                                    </div>
                                    <div id="cont">
                                        <div>{{ strtoupper($slot->account_name) }}</div>
                                        <b>{{ $slot->membership_name }}</b>
                                    </div>
                                    <div>{{ $slot->slot_type }}</div>
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
@endif

