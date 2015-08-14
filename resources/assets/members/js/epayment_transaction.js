
function transaction()
{

}


transaction.prototype.show_details = function($agentRefNo)
{
	this.$agentRefNo = $agentRefNo;
	$.ajax({
		url: 'member/e-payment/transaction-log/show_details',
		type: 'GET',
		dataType: 'html',
		data: {agentRefNo: $agentRefNo},
	})
	.done(function(html){
		$('#show-details-div').html(html);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	


}

$(document).ready(function()
{	

	var showDetailRemodal = $('[data-remodal-id=showDetails]').remodal();
	var showReloadRemodal = $('[data-remodal-id=reload-e-wallet-modal]').remodal();
	$( "#datatable tbody" ).on( "click", "tr .view-details", function() {
		var $agentRefNo = $(this).attr('agentRefNo');
		showDetailRemodal.open();
		var $transaction = new transaction();
		$transaction.show_details($agentRefNo);
	});

	$('.reload-wallet-show').on('click', function()
	{
		showReloadRemodal.open();
	});

});