
var layout = new layout();


function layout()
{
	$(document).ready(function()
	{
		initialize();
	});

	function initialize()
	{
       $('.forslotchanging').click(function()
       {
       		    $.ajax(
                {
                            url:"member/slot/changeslot",
                            dataType:"json",
                            data: {'changeslot':$(this).attr('slotid')},
                            type:"post",
                            success: function(data)
                            {
	                            	window.location.href = window.location.pathname;
                            }
                });      
       });
	}



}