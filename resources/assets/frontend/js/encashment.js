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
		check_value();
		country = jQuery.parseJSON($(".forhidden").val());

	}


	function initialize()
	{	


		$("#clickencash").click(function()
		{	


			// 		 var test = ;
		 // alert(test);
			deduction = 0;

			var one = (parseFloat($("#amount").val())).formatMoney(2); 
			var two = $(".max").attr('val');
			var four = 0;
			var five = 0;
			$("#enc").val($("#typeencashment").val());
			$("#two").val(one);
			$("#one").val(two);
			$("#three").val((two-one).formatMoney(2));
			$("#four").val(four);
			$("#five").val(five);
			
			var recievable = compute_recievable(one)
			$("#six").val((recievable).formatMoney(2));
			// console.log(recievable);
			var inst = $('[data-remodal-id=encashment]').remodal();
          	inst.open(); 
          	check_value();
		});

		$(".forhistory").click(function(){
			var inst = $('[data-remodal-id=encashment_history]').remodal();
          	inst.open(); 
		});
	}
	function compute_recievable(encashment)
	{

		var f_total = 0;
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

        	$("#"+value.deduction_id).val((parseFloat(total2)).formatMoney(2));

        	f_total = parseFloat(total2) + parseFloat(f_total);
        });


        // alert(f_total);
        return parseFloat(encashment) - parseFloat(f_total);
        

        // $("#six").val(parseInt($("#two").val()) - parseInt(deduction));
	}

	function check_value()
	{
        if(parseInt($("#six").val()) >= 0 && parseInt($("#three").val()) >= 0)
        {
        	$('#checkconfirmation').prop("disabled", false);
        }
       	else
        {
        	$('#checkconfirmation').prop("disabled", true);
        }

	}

}
