var g_width = 0;
var half;

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
        initialize_screen_position();
        registration_form_event();
        child_load_event();
    }
    function child_load_event()
    {
        $(".view-downlines").unbind("click");
        $(".view-downlines").bind("click", function(e)
        {
            $slot_id = $(e.currentTarget).closest(".parent").attr("slot_id");

            if($(".parent[slot_id=" + $slot_id + "]").siblings(".child-container").html() == "")
            {
                load_downline($slot_id);    
                $(e.currentTarget).addClass("active");
            }
            else
            {
                $(".parent[slot_id=" + $slot_id + "]").siblings(".child-container").html("");
                adjust_tree();
                $(e.currentTarget).removeClass("active");
            }
            
        });
    }
    function load_downline($slot_id)
    {
        $(".parent[slot_id=" + $slot_id + "]").siblings(".child-container").load('admin/maintenance/slots/downline?id=' + $slot_id, function()
        {
            child_load_event();
            registration_form_event();
            adjust_tree();
        });
    }
    function registration_form_event_bind()
    {
        $(".submit-add-save").unbind("submit");
        $(".submit-add-save").bind("submit", function()
        {
            $.ajax(
            {
                url:"admin/maintenance/slots/add_form_submit",
                dataType:"json",
                data: $(".submit-add-save").serialize(),
                type:"post",
                success: function(data)
                {
                    load_downline(data)
                    var x = $(this).attr("href");      
                    var url = window.location.href.split('#')[0];
                    window.location.href = url+"#";
                }
            });
            
            return false;
        });

        $(".submit-update-slot").unbind("submit");
        $(".submit-update-slot").bind("submit", function()
        {
            $.ajax(
            {
                url:"admin/maintenance/slots/edit_form_submit",
                dataType:"json",
                data: $(".submit-update-slot").serialize(),
                type:"post",
                success: function(data)
                {
                    load_downline(data)
                    var x = $(this).attr("href");      
                    var url = window.location.href.split('#')[0];
                    window.location.href = url+"#";
                }
            });
            
            return false;
        });
    }
    function registration_form_event()
    {
        $(".add-new-slot").click(function(e)
        {
            placement = $(e.currentTarget).attr("placement");
            position = $(e.currentTarget).attr("position");
            $(".new-slot-form").load('admin/maintenance/slots/add_form?placement=' + placement + '&position=' + position, function()
            {
                var x = $(this).attr("href");      
                var url = window.location.href.split('#')[0];
                window.location.href = url+"#newslot";
                registration_form_event_bind(); 
                add_change_owner_event();
            });
        });
        
        $(".parent .name").unbind("click")
        $(".parent .name").bind("click", function(e)
        {
            placement = $(e.currentTarget).closest(".parent").attr("placement");
            position = $(e.currentTarget).closest(".parent").attr("position");
            slot_id = $(e.currentTarget).closest(".parent").attr("slot_id");

            $(".new-slot-form").load('admin/maintenance/slots/edit_form?placement=' + placement + '&position=' + position + '&slot_id=' + slot_id, function()
            {
                var x = $(this).attr("href");      
                var url = window.location.href.split('#')[0];
                window.location.href = url+"#newslot";
                registration_form_event_bind(); 
                add_change_owner_event();
            });
        });
    }
    function add_change_owner_event()
    {
        $(".slot_owner_change").unbind("change");
        $(".slot_owner_change").bind("change", function(e)
        {
            $owner = $(e.currentTarget).val();

            if($owner == 0)
            {
                $(".account-info").show();
            }
            else
            {
                $(".account-info").hide();
            }
        });
    }
    function initialize_screen_position()
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
    }
    function add_click_event_to_downlines()
    {      
        $(".downline").unbind("click");
        $(".downline").bind("click", function(e)
        {
            
            $currentScroll = $(".overscroll").scrollLeft();
            
            if($(e.currentTarget).siblings(".downline-container").find("ul").length == 0)
            {
                $(e.currentTarget).append("<div class='loading'><img src='assets/modules/backend/images/loaders/714.GIF'></div>");
                $(".downline").unbind("click");
                
                $genealogy = $(e.currentTarget).attr("genealogy_function");
                $networker_account_id = $(e.currentTarget).attr("x");
                
                $.ajax(
                {
                    url:"genealogy_get",
                    dataType:"json",
                    data:{x:$networker_account_id,complan_library:$genealogy,mode:mode},
                    type:"post",
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