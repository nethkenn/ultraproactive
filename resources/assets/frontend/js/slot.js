 var slot = new slot();
function slot()
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
		getdata();
		onmembershipchange();	
	}
	function getdata()
	{
		$('.upbtn').bind('click',function(){
			initialize($(this).attr('memship')); 
			$('#tols').val($(this).attr('tols'));
			$('#tu').val($(this).attr('wallet'));
			checkvalue();
			var inst = $('[data-remodal-id=upgrade_member]').remodal();
          	inst.open(); 
		});
	}
	function onmembershipchange()
	{
		$("#wan").bind('change',function()
		{
			$("#tri").val($(this).find(':selected').attr('amount'));
			checkvalue();
		});
	}
	function initialize($price)
	{
        if($("#wan").data('options') == undefined)
        {
          $("#wan").data('options',$('#wan option').clone());
        }
        $(".alerted").hide();
        var options = $('#wan').data('options').filter(function() {
		return $(this).attr("amount") > parseInt($price);
		})

        $('#wan').html(options);

        if(!$('#wan').has('option').length > 0 )
        {
        	$('#subup').prop("disabled", true);
        }
        else
        {
        	$('#subup').prop("disabled", false);
        }
		$("#tri").val($("#wan").find(':selected').attr('amount'));
	}
	function checkvalue()
	{
		$wallet = $("#tu").val();
		$upamount = $("#tri").val();
		if(parseInt($wallet) >= parseInt($upamount))
		{
			$(".alerted").hide();
			$('#subup').prop("disabled", false);
		}
		else
		{
			$('#subup').prop("disabled", true);
			$(".alerted").show();
		}
		if(!$('#wan').has('option').length > 0 )
        {
        	$(".alerted").hide();
        }
	}
}

