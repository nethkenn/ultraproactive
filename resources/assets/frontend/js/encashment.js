var encashment = new encashment();
var country = null;
var deduction = 0;
function encashment()
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
		initialize();
		country = jQuery.parseJSON($(".forhidden").val());
	}


	function initialize()
	{
		$("#clickencash").click(function()
		{	
			deduction = 0;
			var one = $("#amount").val();
			var two = $(".max").attr('val');
			var four = 0;
			var five = 0;
			$("#enc").val($("#typeencashment").val());
			$("#two").val(one);
			$("#one").val(two);
			$("#three").val(parseInt(two)-parseInt(one));
			$("#four").val(four);
			$("#five").val(five);
			$("#six").val(parseInt($("#three").val())-(parseInt(four)+parseInt(five)))
			compute_country();
			var inst = $('[data-remodal-id=encashment]').remodal();
          	inst.open(); 
		});

		$(".forhistory").click(function(){
			var inst = $('[data-remodal-id=encashment_history]').remodal();
          	inst.open(); 
		});
	}
	function compute_country()
	{
		$.each( country.forjson, function( key, value ) 
        {
        	var total2 = 0;
        	if(value.percent == 1)
        	{
        		deduction = deduction + ($("#two").val()*(value.deduction_amount/100));
        		total2 = $("#two").val()*(value.deduction_amount/100);
        	} 
        	else
        	{
        		deduction = deduction + value.deduction_amount;
        		total2 = value.deduction_amount;
        	}
        	$("#"+value.deduction_id).val(total2);
        });

        $("#six").val(parseInt($("#two").val())-deduction);
	}

}

