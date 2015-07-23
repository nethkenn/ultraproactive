var code_vault = new code_vault();
var list = null;

function code_vault()
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
		// getdata();
		initialize();
		onmembershipchange();	
		add_event_active_product();
		product_included();
		checkifavailable();
		init_showdownline();
		showdownline();
	}
	// function getdata()
	// {
	// 	$('.upbtn').bind('click',function(){
	// 		initialize($(this).attr('memship')); 
	// 		$('#tols').val($(this).attr('tols'));
	// 		$('#tu').val($(this).attr('wallet'));
	// 		checkvalue();

	// 	});
	// }
	function onmembershipchange()
	{
		$("#11111").bind('change',function()
		{
			$("#33333").val($(this).find(':selected').attr('amount'));
			checkvalue();
		});
	}
	function initialize($price)
	{
		$("#buymember").click(function()
		{
			$("#33333").val($("#11111").find(':selected').attr('amount'));
			checkvalue();
			var inst = $('[data-remodal-id=buy_code]').remodal();
          	inst.open(); 
		});

		$(".createslot").click(function()
		{
			$val = $(this).attr('value');
			$("#code_number").val($val);
			var inst = $('[data-remodal-id=create_slot]').remodal();
          	inst.open(); 
		});

		$(".claim_code").click(function()
		{
			var inst = $('[data-remodal-id=claim_code]').remodal();
          	inst.open(); 
		});

		$(".transferer").click(function()
		{
			$("#11").val($(this).attr('value'));
			$("#11s").val($(this).attr('val'));
			var inst = $('[data-remodal-id=transfer_code]').remodal();
          	inst.open(); 
		})
		$(".alertused").click(function()
		{
			alert("Already used.");
		})

	      if($('#11111').data('options') == undefined)
	      {
	          $('#11111').data('options',$('#packageincluded option').clone());
	      } 
	      var id = $('option:selected', '#11111').attr('included');

	      var options = $('#11111').data('options').filter('[included=' + id + ']');
	      $('#packageincluded').html(options);

	      if($('#packageincluded option').size() == 0)
	      {
	        $('#packageincluded').append('<option value="" class="shouldremove">No package available for this membership</option>');  
	     	$('#ifbuttoncode').prop("disabled", true);
	     	$(".includer").hide();
	      }
	      else
	      {
	      	$(".includer").show();
	      	$('#ifbuttoncode').prop("disabled", false);
	      	list = jQuery.parseJSON($('option:selected', "#packageincluded").attr('json'));
		    $(".productinclude").empty();
			showlist();
	      }


	}
	function checkvalue()
	{
		$wallet = parseInt($("#22222").val());
		$upamount = parseInt($("#33333").val());
		$total = $wallet - $upamount;
		$("#44444").val($total);
		if($total >= 0)
		{
			$('#ifbuttoncode').prop("disabled", false);
		}
		else
		{
			$('#ifbuttoncode').prop("disabled", true);
		}

		if($('#packageincluded').val() == 0)
		{
			$('#ifbuttoncode').prop("disabled", true);	
		}
		else
		{
			$('#ifbuttoncode').prop("disabled", false);
		}
	}
	function add_event_active_product()
    {
        $(".checklock").unbind("click");
        $(".checklock").bind("click", function(e)
        {
            $lock = $(e.currentTarget).closest("tr").attr("loading");
            if($(this).prop('checked')==false)
            {
            	var inst = $('[data-remodal-id=required_pass]').remodal();
            	$("#yuan").val($lock);
          		inst.open();
          		return false;
            }
            else
            {
                $(this).prop('checked',true);    
                set_active($lock, 1);
            }
        });
    }
    function set_active($lock, $value)
    {
        $.ajax(
        {
            url:"/member/code_vault/lock",
            dataType:"json",
            data:{ "pin":$lock, "value": $value, "_token": $(".token").val() },
            type:"post",
            success: function(data)
            {
            }
        })
    } 
    function product_included()
    {
		$("#11111").change(function() 
		{

		              if($(this).data('options') == undefined)
		              {
		                  $(this).data('options',$('#packageincluded option').clone());
		              } 
		              var id = $('option:selected', this).attr('included');

		              var options = $(this).data('options').filter('[included=' + id + ']');
		              $('#packageincluded').html(options);

		              if($('#packageincluded option').size() == 0)
		              {
		                $('#packageincluded').append('<option value="" class="shouldremove">No package available for this membership</option>');  
		             	$('#ifbuttoncode').prop("disabled", true);
		             	$(".includer").hide();	
		              }
		              else
		              {
		              	$(".includer").show();
		              	$('#ifbuttoncode').prop("disabled", false);
		              	list = jQuery.parseJSON($('option:selected', "#packageincluded").attr('json'));
		              	checkvalue();
		              	showlist();
		              }
		});

		$("#packageincluded").change(function()
		{
	    	list = jQuery.parseJSON($('option:selected', this).attr('json'));
			$(".productinclude").empty();
    		showlist();
		});
    }
    function showlist()
    {
    	  $(".productinclude").empty();
           $.each(list, function( key, value ) 
            {
	            var id = value.product_id;
                var name = value.product_name;
                var price = value.price;
                var quantity = value.quantity;
                var total = parseInt(price) * parseInt(quantity);
                var str="";

                 str =  '<tr class="text-center">'+
                            '<td>'+id+'</td>'+
                            '<td>'+name+'</td>'+
                            '<td>'+price+'</td>'+
                            '<td>'+total+'</td>'+
                            '<td>'+quantity+'</td>'+
                        '</tr>';
                $(".productinclude").append(str);      
            }); 
    }
    function checkifavailable()
    {
    	$(".c_slot").unbind("click");
        $(".c_slot").bind("click", function(e)
        {
    	    e.preventDefault();
			var form = this;
            $('.c_slot').prop("disabled", true);	
            $.ajax(
            {
                url:"member/code_vault/check",
                dataType:"json",
                data: {'placement':$("#2").val(),'slot_position':$("#3").val(),'code_number' : $("#code_number").val()},
                type:"post",
                success: function(data)
                {
                    if(data.message == "")
                    {
                    	$("#createslot").submit();
                    }
                    else
                    {
                    	$('.c_slot').prop("disabled", false);
                    	$(e.currentTarget).find("button").removeAttr("disabled");
                        alert(data.message);
                        return false;
                    }
                }
            });
            
        });
    }
    function showdownline()
    {
		$(".sponse").keyup(function()
		{
		            $.ajax(
		            {
		                url:"member/code_vault/get",
		                dataType:"json",
		                data: {'slot':$(".sponse").val()},
		                type:"post",
		                success: function(data)
		                {
		                	if(data != "x")
		                	{
		                	  $(".treecon").show();		                		
		    				  $(".tree").empty(); 
		    				  $x = jQuery.parseJSON(data);
		    				  var str ="<option value='"+$(".sponse").val()+"'>Slot #"+$(".sponse").val()+"</option>";
				              $.each($x, function( key, value ) 
				              {
				              		str = str + '<option value="'+value+'">Slot #'+value+'</option>';  
				              }); 	
				              $(".tree").append(str); 
				              $('.c_slot').prop("disabled", false);		                		
		                	}
		                	else
		                	{
		                		if($('.sponse').val() == "")
		                		{
			                		$('.c_slot').prop("disabled", true);
			                		$(".tree").empty();
			                		$(".tree").append('<option value="">Input a slot sponsor</option>');
		                		} 
		                		else
		                		{
			                		$('.c_slot').prop("disabled", true);
			                		$(".tree").empty();
			                		$(".tree").append('<option value="">Sponsor slot number does not exist.</option>');
		                		}
 
		                	}
		                }
		            }); 
		});
    }
    function init_showdownline()
    {
		            $.ajax(
		            {
		                url:"member/code_vault/get",
		                dataType:"json",
		                data: {'slot':$(".sponse").val()},
		                type:"post",
		                success: function(data)
		                {
		                	if(data != "x")
		                	{
		                	  $(".treecon").show();
		    				  $(".tree").empty(); 
		    				  $x = jQuery.parseJSON(data);
		    				  var str ="<option value='"+$(".sponse").val()+"'>Slot #"+$(".sponse").val()+"</option>";
				              $.each($x, function( key, value ) 
				              {
				              		str = str + '<option value="'+value+'">Slot #'+value+'</option>';  
				              }); 	
				              $(".tree").append(str); 
				              $('.c_slot').prop("disabled", false);		                		
		                	}
		                	else
		                	{
		                		if($('.sponse').val() == "")
		                		{
			                		$('.c_slot').prop("disabled", true);
			                		$(".tree").empty();
			                		$(".tree").append('<option value="">Input a slot sponsor</option>');
		                		} 
		                		else
		                		{
			                		$('.c_slot').prop("disabled", true);
			                		$(".tree").empty();
			                		$(".tree").append('<option value="">Sponsor slot number does not exist.</option>');
		                		}
 
		                	}
 
		                }
		            }); 
    }


    // function checkifavailable()
    // {
    //     $(".c_slot").bind("click", function(e)
    //     {	

            
    //     });
    // }   
}

